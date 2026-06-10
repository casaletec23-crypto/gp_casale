function adicionarEstoque(e) {
  e.preventDefault();
  const dadosFormulario = {
    nome:      document.getElementById('e_nome').value,
    categoria: document.getElementById('e_cat').value,
    qtd:       parseFloat(document.getElementById('e_qtd').value) || 0,
    min:       parseFloat(document.getElementById('e_min').value) || 0,
    val:       parseFloat(document.getElementById('e_val').value) || 0
  };
  inserirRegistro('estoque', dadosFormulario);
  e.target.reset();
}

function removerEstoque(id) { excluirRegistro('estoque', id); }

function alterarQtdEstoque(id, diff) {
  const item = estoque.find(e => e.id === id);
  if(item) {
    const novaQtd = Math.max(0, item.qtd + diff);
    atualizarRegistro('estoque', id, { qtd: novaQtd });
  }
}

function renderEstoque() {
  const tbody = document.getElementById('lista_estoque');
  if (!tbody) return;
  tbody.innerHTML = '';
  
  if (document.getElementById('estoque_total')) document.getElementById('estoque_total').textContent = fmt(estoque.reduce((a, e) => a + (e.qtd * e.val), 0));
  
  [...estoque].forEach(e => {
    const isLow = e.qtd <= e.min;
    const statusClass = isLow ? 'bg-rose-500/10 text-rose-400 border border-rose-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20';
    const totalValue = e.qtd * e.val;

    const tr = document.createElement('tr');
    tr.className = 'hover:bg-white/[0.04] transition-colors';
    tr.innerHTML = `
      <td class="px-6 py-4 text-xs font-bold text-white">${e.nome}</td>
      <td class="px-6 py-4 text-xs"><span class="bg-slate-800 text-slate-300 px-2 py-1 rounded-md text-[10px] uppercase font-bold">${e.categoria}</span></td>
      <td class="px-6 py-4 text-xs text-center font-black">
        <div class="flex items-center justify-center gap-2">
          <button onclick="alterarQtdEstoque(${e.id}, -1)" class="w-6 h-6 rounded bg-slate-800 text-slate-400 hover:bg-slate-700">-</button>
          <span class="w-8 text-center text-white ${isLow ? 'text-rose-400' : ''}">${e.qtd}</span>
          <button onclick="alterarQtdEstoque(${e.id}, 1)" class="w-6 h-6 rounded bg-slate-800 text-slate-400 hover:bg-slate-700">+</button>
        </div>
      </td>
      <td class="px-6 py-4 text-xs text-center text-slate-400">${e.min}</td>
      <td class="px-6 py-4 text-xs font-black mono text-right text-sky-400">${fmt(totalValue)}</td>
      <td class="px-6 py-4 text-center"><span class="px-2 py-1 rounded-md text-[9px] uppercase font-bold ${statusClass}">${isLow ? 'BAIXO' : 'OK'}</span></td>
      <td class="px-6 py-4 text-right"><button onclick="removerEstoque(${e.id})" class="text-slate-600 hover:bg-rose-500/20 hover:text-rose-400 p-1.5 rounded-lg transition-colors">🗑️</button></td>`;
    tbody.appendChild(tr);
  });
}
