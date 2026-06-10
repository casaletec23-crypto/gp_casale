let activeFilters = { entrada: true, saida: true, lucro: true, prejuizo: false };
let activePeriod = '5D';
let chartPrincipal = null;
let chartRosca = null;

function toggleFilter(key) {
  activeFilters[key] = !activeFilters[key];
  const el = document.getElementById('f-' + key);
  if(el) {
      el.classList.toggle('filter-on',  activeFilters[key]);
      el.classList.toggle('filter-off', !activeFilters[key]);
  }
  renderGraficoPrincipal();
}

function setPeriod(p) {
  activePeriod = p;
  document.querySelectorAll('[id^="p-"]').forEach(b => b.classList.remove('active-period'));
  const activeBtn = document.getElementById('p-' + p);
  if(activeBtn) activeBtn.classList.add('active-period');
  renderGraficoPrincipal();
}

function atualizarDashboard() {
  const totalPago     = vendas.filter(v => v.status === 'Pago').reduce((a, v) => a + v.total, 0);
  const totalCalote   = vendas.filter(v => v.status === 'Calote').reduce((a, v) => a + v.total, 0);
  const totalGastos   = gastos.reduce((a, g) => a + g.valor, 0);
  const totalPessoal  = pessoal.reduce((a, p) => a + p.valor, 0);
  const lucro         = totalPago - totalGastos - totalPessoal;
  
  if(document.getElementById('dash_pago')) document.getElementById('dash_pago').textContent = fmt(totalPago);
  if(document.getElementById('dash_pendente')) document.getElementById('dash_pendente').textContent = fmt(totalCalote);
  if(document.getElementById('dash_gastos')) document.getElementById('dash_gastos').textContent = fmt(totalGastos);
  if(document.getElementById('dash_lucro')) document.getElementById('dash_lucro').textContent = fmt(lucro);
  if(document.getElementById('dash_pessoal_total')) document.getElementById('dash_pessoal_total').textContent = fmt(totalPessoal);
}

function getDatasDosPeriodo() {
  const hojeDate = new Date(); hojeDate.setHours(0,0,0,0);
  const datas = []; let inicio;
  
  if      (activePeriod === '1D')  inicio = new Date(hojeDate);
  else if (activePeriod === '5D')  { inicio = new Date(hojeDate); inicio.setDate(inicio.getDate() - 4); }
  else if (activePeriod === 'mes') { inicio = new Date(hojeDate); inicio.setDate(1); }
  else if (activePeriod === 'ano') { inicio = new Date(hojeDate.getFullYear(), 0, 1); }
  else if (activePeriod === '5A')  { inicio = new Date(hojeDate.getFullYear() - 4, 0, 1); }
  else { 
    const todasDatas = [...vendas.map(v => v.data), ...gastos.map(g => g.data)];
    if (!todasDatas.length) return [];
    inicio = new Date(todasDatas.sort()[0]);
  }
  
  const cur = new Date(inicio);
  while (cur <= hojeDate) {
    datas.push(cur.toISOString().slice(0,10));
    if (activePeriod === 'ano' || activePeriod === '5A') { cur.setMonth(cur.getMonth() + 1); } 
    else { cur.setDate(cur.getDate() + 1); }
  }
  return [...new Set(datas)];
}

function renderGraficoPrincipal() {
  const labels = getDatasDosPeriodo();
  if (!labels.length) return;
  const canvas = document.getElementById('grafico_principal');
  if(!canvas) return;
  
  const fmt2 = (d) => {
    if (activePeriod === 'ano' || activePeriod === '5A') {
      const [y, m] = d.split('-');
      return ['JAN','FEV','MAR','ABR','MAI','JUN','JUL','AGO','SET','OUT','NOV','DEZ'][parseInt(m)-1] + '/' + y.slice(2);
    }
    const [, m, day] = d.split('-');
    return `${day}/${m}`;
  };
  
  const agrupar = (arr, campo) => labels.map(l => {
    if (activePeriod === 'ano' || activePeriod === '5A') {
      const prefix = l.slice(0,7);
      return arr.filter(i => i.data.startsWith(prefix)).reduce((a, i) => a + (i[campo] || 0), 0);
    }
    return arr.filter(i => i.data === l).reduce((a, i) => a + (i[campo] || 0), 0);
  });
  
  const entradas  = agrupar(vendas.filter(v => v.status === 'Pago'), 'total');
  const saidas    = agrupar(gastos, 'valor');
  const prejuizos = agrupar(vendas.filter(v => v.status === 'Calote'), 'total');
  const lucros    = entradas.map((e, i) => e - saidas[i]);
  
  const datasets = [];
  if (activeFilters.entrada)  datasets.push({ label:'Entradas',  data: entradas,  borderColor:'#34d399', backgroundColor:'rgba(52,211,153,0.08)', tension:0.4, fill:true });
  if (activeFilters.saida)    datasets.push({ label:'Saídas',    data: saidas,    borderColor:'#f87171', backgroundColor:'rgba(248,113,113,0.08)', tension:0.4, fill:true });
  if (activeFilters.lucro)    datasets.push({ label:'Lucro',     data: lucros,    borderColor:'#f1f5f9', backgroundColor:'rgba(241,245,249,0.05)', tension:0.4, fill:false });
  if (activeFilters.prejuizo) datasets.push({ label:'Prejuízo',  data: prejuizos, borderColor:'#be123c', backgroundColor:'rgba(190,18,60,0.08)',   tension:0.4, fill:false });
  
  const ctx = canvas.getContext('2d');
  if (chartPrincipal) chartPrincipal.destroy();
  chartPrincipal = new Chart(ctx, { type: 'line', data: { labels: labels.map(fmt2), datasets }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { color:'rgba(255,255,255,0.03)' }, ticks: { color:'#64748b', font:{ size:9 } } }, y: { grid: { color:'rgba(255,255,255,0.03)' }, ticks: { color:'#64748b', font:{ size:9 }, callback: v => 'R$' + v.toLocaleString('pt-BR') } } } } });
}

function renderGraficoRosca() {
  const canvas = document.getElementById('grafico_rosca');
  if(!canvas) return;
  const totalGastos  = gastos.reduce((a,g) => a+g.valor, 0);
  const totalPessoal = pessoal.reduce((a,p) => a+p.valor, 0);
  const totalPago    = vendas.filter(v=>v.status==='Pago').reduce((a,v)=>a+v.total,0);
  const lucro        = Math.max(0, totalPago - totalGastos - totalPessoal);
  
  const ctx = canvas.getContext('2d');
  if (chartRosca) chartRosca.destroy();
  chartRosca = new Chart(ctx, { type: 'doughnut', data: { labels: ['Insumos','Pessoal','Lucro'], datasets: [{ data:[totalGastos, totalPessoal, lucro], backgroundColor:['#f87171','#c084fc','#34d399'], borderWidth:0 }] }, options: { responsive:true, maintainAspectRatio:false, cutout:'70%', plugins:{ legend:{ position:'bottom', labels:{ color:'#94a3b8', font:{size:10} } } } } });
}
