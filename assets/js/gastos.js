function adicionarGasto(e) {
  e.preventDefault();
  const dadosFormulario = {
    data:       document.getElementById('g_data').value || hoje(),
    descricao:  document.getElementById('g_desc').value,
    categoria:  document.getElementById('g_cat').value,
    valor:      parseFloat(document.getElementById('g_val').value) || 0
  };
  inserirRegistro('gastos', dadosFormulario);
  e.target.reset();
  document.getElementById('g_data').value = hoje();
}

function removerGasto(id) { excluirRegistro('gastos', id); }

function renderGastos() {
  const tbody = document.getElementById('lista_gastos');
  if (!tbody) return;
  tbody.innerHTML = '';
  
  if (document.getElementById('gastos_total')) document.getElementById('gastos_total').textContent = fmt(gastos.reduce((a,g) => a+g.valor, 0));
  
  [...gastos].reverse().forEach(g => {
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-white/[0.04] transition-colors';
    tr.innerHTML = `
      <td class="px-6 py-4 text-xs font-bold text-slate-300">${g.data.split('-').reverse().join('/')}</td>
      <td class="px-6 py-4 text-xs text-white">${g.descricao}</td>
      <td class="px-6 py-4 text-xs"><span class="bg-slate-800 text-slate-300 px-2 py-1 rounded-md text-[10px] uppercase font-bold">${g.categoria}</span></td>
      <td class="px-6 py-4 text-xs font-black mono text-right text-rose-400">${fmt(g.valor)}</td>
      <td class="px-6 py-4 text-right"><button onclick="removerGasto(${g.id})" class="text-slate-600 hover:bg-rose-500/20 hover:text-rose-400 p-1.5 rounded-lg transition-colors">🗑️</button></td>`;
    tbody.appendChild(tr);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  if(document.getElementById('g_data')) document.getElementById('g_data').value = hoje();
});
