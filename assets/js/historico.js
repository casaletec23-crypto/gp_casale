function renderHistorico() {
  const tbody = document.getElementById('lista_historico');
  if (!tbody) return;
  tbody.innerHTML = '';
  const todos = [
    ...vendas.map(v => ({ ...v, tipo:'venda', valor: v.total })),
    ...gastos.map(g => ({ ...g, tipo:'gasto' })),
    ...pessoal.map(p => ({ ...p, tipo:'pessoal' }))
  ].sort((a,b) => (b.data+b.hora||'') > (a.data+a.hora||'') ? 1 : -1);
  
  const cores = { venda:'text-emerald-400', gasto:'text-rose-400', pessoal:'text-purple-400' };
  const icons = { venda:'↑ VENDA', gasto:'↓ CUSTO', pessoal:'↓ PESSOAL' };
  
  todos.forEach(item => {
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-white/[0.04] transition-colors';
    tr.innerHTML = `
      <td class="px-6 py-4 text-xs font-bold text-slate-300">${item.data.split('-').reverse().join('/')}</td>
      <td class="px-6 py-4"><span class="status-badge ${item.tipo==='venda'?'bg-emerald-500/10 text-emerald-400':item.tipo==='gasto'?'bg-rose-500/10 text-rose-400':'bg-purple-500/10 text-purple-400'}">${icons[item.tipo]}</span></td>
      <td class="px-6 py-4 text-xs text-white">${item.descricao || item.produto || item.nome || ''}</td>
      <td class="px-6 py-4 text-xs font-black mono text-right ${cores[item.tipo]}">${fmt(item.valor)}</td>`;
    tbody.appendChild(tr);
  });
}
