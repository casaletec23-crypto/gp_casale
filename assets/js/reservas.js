function adicionarReserva(e) {
  e.preventDefault();
  const dadosFormulario = {
    data:    document.getElementById('r_data').value || hoje(),
    cliente: document.getElementById('r_cli').value,
    servico: document.getElementById('r_serv').value,
    hora:    document.getElementById('r_hora').value,
    obs:     document.getElementById('r_obs').value,
    status:  document.getElementById('r_sta').value
  };
  inserirRegistro('reservas', dadosFormulario);
  e.target.reset();
  document.getElementById('r_data').value = hoje();
  document.getElementById('r_hora').value = agora();
}

function removerReserva(id) { excluirRegistro("reservas", id); }

function renderReservas() {
  const tbody = document.getElementById('lista_reservas');
  if (!tbody) return;
  tbody.innerHTML = '';
  const cores = { Confirmada:'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20', Pendente:'bg-amber-500/10 text-amber-400 border border-amber-500/20', Cancelada:'bg-rose-500/10 text-rose-400 border border-rose-500/20' };
  
  [...reservas].sort((a,b) => (a.data+a.hora) > (b.data+b.hora) ? -1 : 1).forEach(r => {
    const tr = document.createElement('tr');
    tr.className = 'hover:bg-white/[0.04] transition-colors';
    tr.innerHTML = `
      <td class="px-6 py-4 text-xs font-bold text-slate-300 whitespace-nowrap">${r.data.split('-').reverse().join('/')} <span class="ml-1 px-1.5 py-0.5 rounded bg-black/40 text-amber-400">${r.hora}</span></td>
      <td class="px-6 py-4 text-xs font-bold text-white">${r.cliente}</td>
      <td class="px-6 py-4 text-xs text-slate-300"><span class="bg-slate-800 text-slate-300 px-2 py-1 rounded-md text-[10px] uppercase font-bold">${r.servico}</span></td>
      <td class="px-6 py-4 text-xs text-slate-400 italic">${r.obs || '-'}</td>
      <td class="px-6 py-4 text-center"><span class="px-2 py-1 rounded-md text-[9px] uppercase font-bold ${cores[r.status]}">${r.status}</span></td>
      <td class="px-6 py-4 text-right"><button onclick="removerReserva(${r.id})" class="text-slate-600 hover:bg-rose-500/20 hover:text-rose-400 p-1.5 rounded-lg transition-colors">🗑️</button></td>`;
    tbody.appendChild(tr);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  if(document.getElementById('r_data')) document.getElementById('r_data').value = hoje();
  if(document.getElementById('r_hora')) document.getElementById('r_hora').value = agora();
});
