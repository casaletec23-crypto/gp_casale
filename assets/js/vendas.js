function adicionarVenda(e) {
  e.preventDefault();
  const quantidade = parseFloat(document.getElementById('v_qtd').value) || 1;
  const valor = parseFloat(document.getElementById('v_val').value) || 0;
  
  const dadosFormulario = {
    data: document.getElementById('v_data').value || hoje(),
    hora: document.getElementById('v_hora').value || agora(),
    cliente: document.getElementById('v_cli').value,
    produto: document.getElementById('v_prod').value,
    quantidade: quantidade,
    valor: valor,
    total: quantidade * valor,
    status: document.getElementById('v_sta').value
  };

  inserirRegistro('vendas', dadosFormulario); 
  e.target.reset();
  document.getElementById('v_data').value = hoje();
  document.getElementById('v_hora').value = agora();
}

function removerVenda(id) { excluirRegistro('vendas', id); }

function alternarStatusVenda(id) {
  const ordem = ['Pendente', 'Pago', 'Calote'];
  const venda = vendas.find(v => v.id === id);
  if (venda) {
    const novoStatus = ordem[(ordem.indexOf(venda.status) + 1) % ordem.length];
    atualizarRegistro('vendas', id, { status: novoStatus });
  }
}

function renderVendas() {
  const tbody = document.getElementById('lista_vendas');
  if (!tbody) return;
  tbody.innerHTML = '';

  const recebido = vendas.filter(v => v.status === 'Pago').reduce((a, v) => a + v.total, 0);
  const pendente = vendas.filter(v => v.status === 'Pendente').reduce((a, v) => a + v.total, 0);
  const calote = vendas.filter(v => v.status === 'Calote').reduce((a, v) => a + v.total, 0);
  
  if (document.getElementById('vendas_recebido')) document.getElementById('vendas_recebido').textContent = fmt(recebido);
  if (document.getElementById('vendas_pendente_total')) document.getElementById('vendas_pendente_total').textContent = fmt(pendente);
  if (document.getElementById('vendas_calote_total')) document.getElementById('vendas_calote_total').textContent = fmt(calote);

  const cores = { Pago: 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20', Pendente: 'bg-amber-500/10 text-amber-400 border-amber-500/20', Calote: 'bg-rose-500/10 text-rose-400 border-rose-500/20' };

  [...vendas].reverse().forEach(v => {
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-white/[0.04] transition-colors group';
    tr.innerHTML = `
      <td class="px-6 py-4 text-xs font-bold text-slate-300">${v.data.split('-').reverse().join('/')} <span class="opacity-50">${v.hora}</span></td>
      <td class="px-6 py-4 text-xs font-bold text-white">${v.cliente}</td>
      <td class="px-6 py-4 text-xs text-slate-400">${v.produto}</td>
      <td class="px-6 py-4 text-xs text-center text-slate-400 bg-black/20">${v.quantidade}</td>
      <td class="px-6 py-4 text-xs font-black mono text-right text-white">${fmt(v.total)}</td>
      <td class="px-6 py-4 text-center"><button onclick="alternarStatusVenda(${v.id})" class="status-badge border ${cores[v.status]} hover:brightness-125 transition-all cursor-pointer">${v.status}</button></td>
      <td class="px-6 py-4 text-right"><button onclick="removerVenda(${v.id})" class="text-slate-600 hover:bg-rose-500/20 hover:text-rose-400 p-1.5 rounded-lg transition-colors">🗑️</button></td>`;
    tbody.appendChild(tr);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  if(document.getElementById('v_data')) document.getElementById('v_data').value = hoje();
  if(document.getElementById('v_hora')) document.getElementById('v_hora').value = agora();
});
