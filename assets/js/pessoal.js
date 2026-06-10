function adicionarPessoal(e) {
  e.preventDefault();
  const dadosFormulario = {
    data:      document.getElementById('p_data').value || hoje(),
    nome:      document.getElementById('p_nome').value,
    descricao: document.getElementById('p_desc').value,
    valor:     parseFloat(document.getElementById('p_val').value) || 0
  };
  inserirRegistro('pessoal', dadosFormulario); 
  e.target.reset();
  document.getElementById('p_data').value = hoje();
}

function removerPessoal(id) { excluirRegistro('pessoal', id); }

function renderPessoal() {
  const tbody = document.getElementById('lista_pessoal');
  if (!tbody) return;
  tbody.innerHTML = '';
  
  if (document.getElementById('pessoal_total')) document.getElementById('pessoal_total').textContent = fmt(pessoal.reduce((a,p) => a+p.valor, 0));
  
  [...pessoal].reverse().forEach(p => {
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-white/[0.04] transition-colors';
    tr.innerHTML = `
      <td class="px-6 py-4 text-xs font-bold text-slate-300">${p.data.split('-').reverse().join('/')}</td>
      <td class="px-6 py-4 text-xs font-bold text-white">${p.nome}</td>
      <td class="px-6 py-4 text-xs text-slate-400">${p.descricao}</td>
      <td class="px-6 py-4 text-xs font-black mono text-right text-purple-400">${fmt(p.valor)}</td>
      <td class="px-6 py-4 text-right"><button onclick="removerPessoal(${p.id})" class="text-slate-600 hover:bg-rose-500/20 hover:text-rose-400 p-1.5 rounded-lg transition-colors">🗑️</button></td>`;
    tbody.appendChild(tr);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  if(document.getElementById('p_data')) document.getElementById('p_data').value = hoje();
});
