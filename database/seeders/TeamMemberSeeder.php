<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Siembra les miembros de equipo a partir de database/data/horarios.csv.
 *
 * Jerarquía:
 *   director → jefe → coordinador → [supervisor, operador]
 *
 * Mapeo a teams:
 *   - Los equipos "Coordinacion 1-9" (IDs 5-13) corresponden a los
 *     9 coordinadores únicos del CSV, en orden de primera aparición.
 *   - El supervisor_id de cada equipo queda actualizado al empleado
 *     coordinador correspondiente.
 *   - Se añaden como team_members: coordinador, supervisor(es) y operadores
 *     bajo cada coordinador.
 *
 * Prerequisitos: EmployeeSeeder y TeamManagerSeeder deben haber corrido.
 */
class TeamMemberSeeder extends Seeder {
    /** ID del primer equipo de coordinación en la tabla teams. */
    private const FIRST_COORDINATOR_TEAM_ID = 5;

    public function run(): void {
        $csvPath = database_path('data/horarios.csv');

        if (!file_exists($csvPath)) {
            $this->command->warn("Archivo no encontrado: {$csvPath}");
            return;
        }

        $rows = $this->readCsv($csvPath);

        // 1. Detectar coordinadores en orden de primera aparición y asignar team_id
        $coordinatorTeamMap = $this->buildCoordinatorTeamMap($rows);

        // 2. Actualizar supervisor_id de cada equipo de coordinación
        $this->updateTeamSupervisors($coordinatorTeamMap);

        // 3. Construir el conjunto de asignaciones (team_id, employee_id) sin duplicados
        $joinedAt = now()->toDateString();
        $memberships = $this->buildMemberships($rows, $coordinatorTeamMap, $joinedAt);

        // 4. Persistir en una sola transacción
        DB::transaction(function () use ($memberships) {
            foreach ($memberships as $m) {
                DB::table('team_members')->updateOrInsert(
                    [
                        'team_id' => $m['team_id'],
                        'employee_id' => $m['employee_id'],
                        'joined_at' => $m['joined_at'],
                    ],
                    [
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        });

        $this->command->info(sprintf(
            'Team members sembrados: %d asignaciones en %d equipos de coordinación.',
            count($memberships),
            count($coordinatorTeamMap)
        ));
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    /**
     * Mapea cada coordinator_username al team_id que le corresponde.
     * El orden de primera aparición en el CSV determina el ID del equipo.
     *
     * @param  array<int, array<string, string>>  $rows
     * @return array<string, int>  coordinator_username → team_id
     */
    private function buildCoordinatorTeamMap(array $rows): array {
        $map = [];
        $nextId = self::FIRST_COORDINATOR_TEAM_ID;

        foreach ($rows as $row) {
            $coordinator = $row['Coordinador'] ?? '';
            if ($coordinator === '') {
                continue;
            }
            if (!isset($map[$coordinator])) {
                $map[$coordinator] = $nextId++;
            }
        }

        return $map;
    }

    /**
     * Actualiza teams.supervisor_id con el employee_id del coordinador.
     *
     * @param  array<string, int>  $coordinatorTeamMap
     */
    private function updateTeamSupervisors(array $coordinatorTeamMap): void {
        foreach ($coordinatorTeamMap as $coordinatorUsername => $teamId) {
            $employeeId = $this->findEmployeeId($coordinatorUsername);

            if ($employeeId === null) {
                $this->command->warn("No se encontró el coordinador: '{$coordinatorUsername}'");
                continue;
            }

            DB::table('teams')
                ->where('id', $teamId)
                ->update([
                    'supervisor_id' => $employeeId,
                    'updated_at' => now(),
                ]);
        }
    }

    /**
     * Construye el mapa de asignaciones únicas (clave = "team_id:employee_id").
     * Cada fila del CSV puede contribuir hasta 3 miembros al mismo equipo:
     * el coordinador, el supervisor y el operador (Usuario).
     *
     * @param  array<int, array<string, string>>  $rows
     * @param  array<string, int>                 $coordinatorTeamMap
     * @param  string                             $joinedAt
     * @return array<string, array{team_id: int, employee_id: int, joined_at: string}>
     */
    private function buildMemberships(array $rows, array $coordinatorTeamMap, string $joinedAt): array {
        $memberships = [];
        /** @var array<string, int|null> $employeeCache */
        $employeeCache = [];

        foreach ($rows as $row) {
            $coordinatorUsername = $row['Coordinador'] ?? '';
            $teamId = $coordinatorTeamMap[$coordinatorUsername] ?? null;

            if ($teamId === null) {
                continue;
            }

            // Los tres roles que pertenecen al equipo del coordinador
            $candidates = array_filter([
                $coordinatorUsername,
                $row['Supervisor'] ?? '',
                $row['Usuario'] ?? '',
            ]);

            foreach ($candidates as $rawUsername) {
                $username = strtolower(trim($rawUsername));
                if ($username === '') {
                    continue;
                }

                if (!array_key_exists($username, $employeeCache)) {
                    $employeeCache[$username] = $this->findEmployeeId($username);
                }

                $employeeId = $employeeCache[$username];

                if ($employeeId === null) {
                    $this->command->warn("Empleado no encontrado (username: '{$username}')");
                    continue;
                }

                $key = "{$teamId}:{$employeeId}";
                $memberships[$key] = [
                    'team_id' => $teamId,
                    'employee_id' => $employeeId,
                    'joined_at' => $joinedAt,
                ];
            }
        }

        return $memberships;
    }

    /**
     * Busca el employee_id por username (case-insensitive).
     */
    private function findEmployeeId(string $username): ?int {
        /** @var int|null $id */
        $id = DB::table('employees')
            ->whereRaw('LOWER(username) = ?', [strtolower(trim($username))])
            ->value('id');

        return $id;
    }

    /**
     * Lee el CSV y devuelve un array asociativo con headers trimmeados.
     *
     * @return array<int, array<string, string>>
     */
    private function readCsv(string $filePath): array {
        $data = [];
        $header = null;

        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, ',')) !== false) {
                if ($header === null) {
                    $header = array_map('trim', $row);
                } elseif (count($header) === count($row)) {
                    $data[] = array_combine($header, array_map('trim', $row));
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
