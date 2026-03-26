```html

<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: var(--font-sans); }
.root { display: flex; gap: 12px; padding: 1rem 0; align-items: flex-start; }
.panel { flex: 1; display: flex; flex-direction: column; gap: 8px; }
.panel select {
  width: 100%; padding: 7px 10px; font-size: 13px;
  border: 0.5px solid var(--color-border-secondary);
  border-radius: var(--border-radius-md);
  background: var(--color-background-primary);
  color: var(--color-text-primary);
  cursor: pointer;
}
.list-box {
  border: 0.5px solid var(--color-border-tertiary);
  border-radius: var(--border-radius-md);
  background: var(--color-background-primary);
  height: 340px; overflow-y: auto;
}
.list-item {
  display: flex; align-items: center; gap: 8px;
  padding: 8px 12px; cursor: pointer;
  border-bottom: 0.5px solid var(--color-border-tertiary);
  font-size: 13px; color: var(--color-text-primary);
  transition: background 0.1s;
}
.list-item:last-child { border-bottom: none; }
.list-item:hover { background: var(--color-background-secondary); }
.list-item input[type=checkbox] { cursor: pointer; accent-color: var(--color-text-info); flex-shrink: 0; }
.avatar {
  width: 26px; height: 26px; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  font-size: 10px; font-weight: 500; flex-shrink: 0;
}
.item-info { flex: 1; min-width: 0; }
.item-name { font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.item-team { font-size: 11px; color: var(--color-text-secondary); margin-top: 1px; }
.badge {
  font-size: 10px; padding: 2px 7px; border-radius: 99px;
  white-space: nowrap; flex-shrink: 0;
  border: 0.5px solid var(--color-border-tertiary);
  color: var(--color-text-secondary);
}
.controls {
  display: flex; flex-direction: column; align-items: center;
  justify-content: center; gap: 8px; padding: 0 4px;
  align-self: center; margin-top: 60px;
}
.ctrl-btn {
  width: 36px; height: 36px; border-radius: var(--border-radius-md);
  border: 0.5px solid var(--color-border-secondary);
  background: var(--color-background-primary);
  color: var(--color-text-primary);
  cursor: pointer; font-size: 15px;
  display: flex; align-items: center; justify-content: center;
  transition: background 0.1s, transform 0.1s;
}
.ctrl-btn:hover { background: var(--color-background-secondary); }
.ctrl-btn:active { transform: scale(0.95); }
.ctrl-btn:disabled { opacity: 0.3; cursor: not-allowed; transform: none; }
.panel-header {
  font-size: 11px; font-weight: 500; color: var(--color-text-secondary);
  text-transform: uppercase; letter-spacing: 0.05em; padding: 0 2px;
}
.count-badge {
  display: inline-flex; align-items: center; justify-content: center;
  background: var(--color-background-info); color: var(--color-text-info);
  font-size: 10px; font-weight: 500;
  width: 18px; height: 18px; border-radius: 99px; margin-left: 6px;
}
</style>

<div class="root">
  <div class="panel">
    <div class="panel-header">Origen <span class="count-badge" id="left-count">0</span></div>
    <select id="left-filter" onchange="renderLeft()"></select>
    <div class="list-box" id="left-list"></div>
  </div>

  <div class="controls">
    <button class="ctrl-btn" id="btn-r" title="Mover seleccionados →" onclick="moveSelected('left','right')" disabled>›</button>
    <button class="ctrl-btn" id="btn-all-r" title="Mover todos →" onclick="moveAll('left','right')" disabled>»</button>
    <button class="ctrl-btn" id="btn-l" title="← Mover seleccionados" onclick="moveSelected('right','left')" disabled>‹</button>
    <button class="ctrl-btn" id="btn-all-l" title="← Mover todos" onclick="moveAll('right','left')" disabled>«</button>
  </div>

  <div class="panel">
    <div class="panel-header">Destino <span class="count-badge" id="right-count">0</span></div>
    <select id="right-filter" onchange="renderRight()"></select>
    <div class="list-box" id="right-list"></div>
  </div>
</div>

<script>
const TEAMS = ['Engineering', 'Design', 'Product', 'Marketing', 'Sales'];
const COLORS = [
  {bg:'#E6F1FB',c:'#0C447C'},{bg:'#EAF3DE',c:'#3B6D11'},
  {bg:'#FAEEDA',c:'#633806'},{bg:'#FAECE7',c:'#712B13'},
  {bg:'#EEEDFE',c:'#3C3489'}
];
const teamColor = t => COLORS[TEAMS.indexOf(t) % COLORS.length] || {bg:'#F1EFE8',c:'#444441'};
const initials = n => n.split(' ').map(x=>x[0]).join('').toUpperCase().slice(0,2);

let people = [
  {id:1,name:'Ana Gutiérrez',team:'Engineering'},{id:2,name:'Carlos Rivas',team:'Engineering'},
  {id:3,name:'María López',team:'Design'},{id:4,name:'Pedro Soto',team:'Design'},
  {id:5,name:'Laura Mendez',team:'Product'},{id:6,name:'Diego Torres',team:'Product'},
  {id:7,name:'Sofia Chen',team:'Marketing'},{id:8,name:'Andrés Park',team:'Marketing'},
  {id:9,name:'Valentina Wu',team:'Sales'},{id:10,name:'Roberto Kim',team:'Sales'},
  {id:11,name:'Isabel Rojas',team:null},{id:12,name:'Miguel Vargas',team:null},
  {id:13,name:'Camila Reyes',team:null},
];

let leftSelected = new Set();
let rightSelected = new Set();

function buildOptions(sel, excludeTeam) {
  const cur = sel.value;
  sel.innerHTML = '';
  const opts = [['all','Todos los empleados'],['none','Sin equipo'],...TEAMS.map(t=>[t,t])];
  opts.forEach(([v,l]) => {
    if (v !== excludeTeam) {
      const o = document.createElement('option');
      o.value = v; o.textContent = l;
      sel.appendChild(o);
    }
  });
  if ([...sel.options].some(o=>o.value===cur)) sel.value = cur;
}

function getFilter(selId) {
  return document.getElementById(selId).value;
}

function filteredPeople(filter) {
  if (filter === 'all') return people;
  if (filter === 'none') return people.filter(p => !p.team);
  return people.filter(p => p.team === filter);
}

function renderList(boxId, filter, selectedSet, countId) {
  const box = document.getElementById(boxId);
  const fp = filteredPeople(filter);
  box.innerHTML = '';
  fp.forEach(p => {
    const div = document.createElement('div');
    div.className = 'list-item';
    div.dataset.id = p.id;
    const cb = document.createElement('input');
    cb.type = 'checkbox';
    cb.checked = selectedSet.has(p.id);
    cb.onchange = e => { e.stopPropagation(); toggle(selectedSet, p.id, e.target.checked); updateButtons(); };
    const col = p.team ? teamColor(p.team) : {bg:'#F1EFE8',c:'#5F5E5A'};
    div.innerHTML = `<input type="checkbox" ${selectedSet.has(p.id)?'checked':''}>
      <div class="avatar" style="background:${col.bg};color:${col.c}">${initials(p.name)}</div>
      <div class="item-info">
        <div class="item-name">${p.name}</div>
        ${p.team ? `<div class="item-team">${p.team}</div>` : '<div class="item-team" style="font-style:italic">Sin equipo</div>'}
      </div>
      ${p.team ? `<span class="badge">${p.team.slice(0,3)}</span>` : ''}`;
    div.querySelector('input').addEventListener('change', e => {
      toggle(selectedSet, p.id, e.target.checked); updateButtons();
    });
    div.addEventListener('click', e => {
      if (e.target.tagName === 'INPUT') return;
      const inp = div.querySelector('input');
      inp.checked = !inp.checked;
      toggle(selectedSet, p.id, inp.checked);
      updateButtons();
    });
    box.appendChild(div);
  });
  document.getElementById(countId).textContent = fp.length;
}

function toggle(set, id, val) { val ? set.add(id) : set.delete(id); }

function renderLeft() { renderList('left-list', getFilter('left-filter'), leftSelected, 'left-count'); updateButtons(); }
function renderRight() { renderList('right-list', getFilter('right-filter'), rightSelected, 'right-count'); updateButtons(); }

function updateButtons() {
  const lf = getFilter('left-filter');
  const rf = getFilter('right-filter');
  const lSel = [...leftSelected].filter(id => filteredPeople(lf).some(p=>p.id===id));
  const rSel = [...rightSelected].filter(id => filteredPeople(rf).some(p=>p.id===id));
  document.getElementById('btn-r').disabled = lSel.length === 0 || rf === 'all';
  document.getElementById('btn-all-r').disabled = filteredPeople(lf).length === 0 || rf === 'all';
  document.getElementById('btn-l').disabled = rSel.length === 0 || lf === 'all';
  document.getElementById('btn-all-l').disabled = filteredPeople(rf).length === 0 || lf === 'all';
}

function resolveTargetTeam(filter) {
  return filter === 'all' || filter === 'none' ? null : filter;
}

function moveSelected(from, to) {
  const fromFilter = getFilter(from+'-filter');
  const toFilter = getFilter(to+'-filter');
  const fromSel = from === 'left' ? leftSelected : rightSelected;
  const visible = filteredPeople(fromFilter).map(p=>p.id);
  const toMove = [...fromSel].filter(id => visible.includes(id));
  const targetTeam = resolveTargetTeam(toFilter);
  toMove.forEach(id => {
    const p = people.find(x=>x.id===id);
    if (p) p.team = targetTeam;
    fromSel.delete(id);
  });
  refreshBoth();
}

function moveAll(from, to) {
  const fromFilter = getFilter(from+'-filter');
  const toFilter = getFilter(to+'-filter');
  const toMove = filteredPeople(fromFilter).map(p=>p.id);
  const fromSel = from === 'left' ? leftSelected : rightSelected;
  const targetTeam = resolveTargetTeam(toFilter);
  toMove.forEach(id => {
    const p = people.find(x=>x.id===id);
    if (p) p.team = targetTeam;
    fromSel.delete(id);
  });
  refreshBoth();
}

function refreshBoth() {
  buildOptions(document.getElementById('left-filter'), null);
  buildOptions(document.getElementById('right-filter'), null);
  renderLeft(); renderRight();
}

const lSel = document.getElementById('left-filter');
const rSel = document.getElementById('right-filter');
buildOptions(lSel, null);
buildOptions(rSel, null);
rSel.value = 'none';
renderLeft(); renderRight();
</script>
```
