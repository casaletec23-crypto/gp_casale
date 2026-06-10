function criarCaixinha(e) {
  e.preventDefault();
  const dadosFormulario = {
    nome:  document.getElementById('cx_nome').value,
    meta:  parseFloat(document.getElementById('cx_meta').value) || 0,
    saldo: parseFloat(document.getElementById('cx_saldo').value) || 0
  };
  inserirRegistro('caixinhas', dadosFormulario);
  e.target.reset();
  if(document.getElementById('form_caixinha')) document.getElementById('form_caixinha').classList.add('hidden');
}

function removerCaixinha(id) { excluirRegistro('caixinhas', id); }

function transacaoCaixinha(id, tipo) {
  const input = document.getElementById(`val_cx_${id}`);
  if(!input) return;
  const valor = parseFloat(input.value);
  if(!valor || valor <= 0) return;

  const caixa = caixinhas.find(c => c.id === id);
  if(caixa) {
    let novoSaldo = caixa.saldo;
    if(tipo === 'in') novoSaldo += valor;
    else if(tipo === 'out' && caixa.saldo >= valor) novoSaldo -= valor;
    else { alert("Saldo insuficiente para resgatar!"); return; }
    atualizarRegistro('caixinhas', id, { saldo: novoSaldo });
  }
}

function renderCaixinhas() {
  const grid = document.getElementById('grid_caixinhas');
  if (!grid) return;
  grid.innerHTML = '';

  if (caixinhas.length === 0) {
    grid.innerHTML = `<div class="col-span-full py-10 text-center border-2 border-dashed border-slate-800 rounded-3xl"><p class="text-slate-500 font-medium">Nenhuma caixinha criada.</p></div>`;
    return;
  }

  caixinhas.forEach(cx => {
    const progresso = cx.meta > 0 ? Math.min(100, Math.round((cx.saldo / cx.meta) * 100)) : 0;
    const colorAccent = progresso >= 100 ? 'emerald' : 'purple';
    
    const card = document.createElement('div');
    card.className = 'caixinha-card p-6 rounded-3xl flex flex-col gap-5 relative overflow-hidden group';
    card.innerHTML = `
      <div class="absolute top-0 left-0 w-full h-1.5 bg-${colorAccent}-500 opacity-80 group-hover:opacity-100 transition-opacity"></div>
      <div class="flex justify-between items-start">
        <h3 class="text-lg font-black text-white leading-tight w-3/4">${cx.nome}</h3>
        <button onclick="removerCaixinha(${cx.id})" class="text-slate-600 hover:text-rose-400 p-1 opacity-0 group-hover:opacity-100 transition-opacity">🗑️</button>
      </div>
      <div>
        <p class="text-[10px] uppercase font-bold text-slate-500 mb-1 tracking-wider">Saldo Atual</p>
        <p class="text-2xl font-black text-${colorAccent}-400 mono tracking-tight">${fmt(cx.saldo)}</p>
      </div>
      <div class="w-full space-y-1">
        <div class="flex justify-between text-[11px] font-bold"><span class="text-slate-400">Progresso</span><span class="text-white">${progresso}%</span></div>
        <div class="w-full bg-slate-800/50 rounded-full h-2.5 overflow-hidden ring-1 ring-slate-700/50">
          <div class="bg-gradient-to-r from-${colorAccent}-600 to-${colorAccent}-400 h-full rounded-full transition-all duration-1000 ease-out" style="width: ${progresso}%"></div>
        </div>
        <p class="text-[10px] text-slate-500 text-right mt-1 font-mono">Meta: ${fmt(cx.meta)}</p>
      </div>
      <div class="bg-black/30 rounded-xl p-2 mt-auto border border-slate-800/50">
         <div class="flex items-center gap-2">
           <input type="number" id="val_cx_${cx.id}" min="0.01" step="0.01" placeholder="R$ 0,00" class="w-full h-9 px-3 rounded-lg bg-transparent text-sm font-bold text-white outline-none border-none">
           <button onclick="transacaoCaixinha(${cx.id}, 'out')" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-black">-</button>
           <button onclick="transacaoCaixinha(${cx.id}, 'in')" class="w-9 h-9 rounded-lg bg-${colorAccent}-500/20 hover:bg-${colorAccent}-500/40 text-${colorAccent}-400 font-black">+</button>
         </div>
      </div>
    `;
    grid.appendChild(card);
  });
}
