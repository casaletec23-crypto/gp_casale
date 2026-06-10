<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GP Casale | Gestão Operacional Definitiva</title>

  <!-- Libs externas -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap"
    rel="stylesheet">

  <!-- CSS Embutido (Original + Novas Funcionalidades) -->
  <link rel="stylesheet" href="styles.css">
</head>

<body class="text-slate-200">

  <!--  ══════════════════════════════════════════
       BARRA DE NAVEGAÇÃO
   ══════════════════════════════════════════  -->
  <nav class="glass-nav sticky top-0 z-50 px-4 py-2">
    <div class="max-w-7xl w-full flex flex-col md:flex-row justify-between items-center gap-4">
      <!-- Logo -->
      <div class="flex items-center gap-3 self-start md:self-auto">
        <div class="bg-amber-400 p-2.5 rounded-xl shadow-lg shadow-amber-400/10">
          <span class="text-slate-900 font-black text-xl italic leading-none">GP</span>
        </div>
        <div>
          <h1 class="text-lg font-black tracking-tighter text-white leading-tight">
            CASALE <span class="text-amber-400">PRO</span>
          </h1>
          <div id="status-loja-nav" class="label-micro flex items-center mt-0.5">
            <span class="status-pulse bg-slate-500"></span> SINCRONIZANDO...
          </div>
        </div>
      </div>
      <!-- Abas -->
      <div
        class="flex items-center gap-1 bg-black/20 p-1 rounded-2xl border border-white/5 no-scrollbar overflow-x-auto w-full md:w-auto">
        <button onclick="switchTab('resumo')" class="nav-btn text-[10px] font-bold uppercase active-resumo"
          id="btn-resumo">Resumo</button>
        <button onclick="switchTab('caixa')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-caixa">Vendas</button>
        <button onclick="switchTab('gastos')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-gastos">Custos</button>
        <button onclick="switchTab('pessoal')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-pessoal">Pessoal</button>
        <button onclick="switchTab('estoque')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-estoque">Estoque</button>
        <button onclick="switchTab('caixinhas')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-caixinhas">Caixinhas</button>
        <button onclick="switchTab('historico')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-historico">Histórico</button>
        <button onclick="switchTab('reservas')" class="nav-btn text-[10px] font-bold uppercase"
          id="btn-reservas">Reservas</button>
      </div>
      <!-- Data -->
      <div class="hidden md:flex flex-col items-end">
        <div id="data-atual" class="text-xs font-black text-white uppercase tracking-widest">---, 00 --</div>
        <div class="label-micro opacity-50">SISTEMA ATIVO</div>
      </div>
    </div>
  </nav>

  <!--  ══════════════════════════════════════════
       CONTEÚDO PRINCIPAL
   ══════════════════════════════════════════  -->
  <main class="max-w-7xl w-full p-4 md:p-8 space-y-8">

    <!-- ── RESUMO (Mantido intacto conforme pedido, apenas removido o '4S') ── -->
    <section id="resumo" class="tab-content active space-y-6">
      <div class="flex flex-col items-center text-center gap-4">
        <div class="mb-2">
          <h2 class="text-3xl font-black text-white tracking-tight">Inteligência Operacional</h2>
          <p class="text-slate-400 text-sm font-medium">Visualização estratégica da saúde financeira.</p>
        </div>
        <div
          class="bg-slate-900/80 px-6 py-4 rounded-3xl border border-slate-800 flex flex-col md:flex-row items-center justify-center gap-6 md:gap-10 w-full max-w-4xl">
          <div class="flex flex-col items-center min-w-[120px]">
            <p class="label-micro !text-amber-400 mb-1">Tempo Real</p>
            <div id="relogio" class="text-2xl font-black text-white mono tracking-tighter leading-none">00:00:00</div>
          </div>
          <div class="flex flex-col md:border-l md:border-slate-800 md:pl-8 items-center">
            <p class="label-micro mb-2">Horário de Operação</p>
            <div class="grid grid-cols-2 gap-x-6 gap-y-1 text-center md:text-left">
              <p class="text-[10px] font-bold text-white"><span class="text-slate-500 mr-1">SEG-SEX:</span> 8h - 20h</p>
              <p class="text-[10px] font-bold text-white"><span class="text-slate-500 mr-1">SÁBADO:</span> 9h - 20h</p>
              <p class="text-[10px] font-bold text-white"><span class="text-slate-500 mr-1">FERIADOS:</span> 9h - 18h
              </p>
              <p class="text-[10px] font-bold text-rose-500"><span class="text-slate-500 mr-1">DOMINGO:</span> FECHADO
              </p>
            </div>
          </div>
          <div class="flex flex-col md:border-l md:border-slate-800 md:pl-8 items-center">
            <p class="label-micro mb-1">Status Operacional</p>
            <p id="health_label" class="text-xl font-black tracking-tight uppercase">ABERTO</p>
            <div id="status-loja-msg" class="text-[9px] font-bold text-slate-500 mt-1 uppercase tracking-tighter">LOJA
              ATENDENDO AGORA</div>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="stat-card border-b-2 border-emerald-500/50">
          <p class="label-micro mb-1">Entradas Totais</p>
          <h3 id="dash_pago" class="text-2xl font-black text-white mono">R$ 0,00</h3>
        </div>
        <div class="stat-card border-b-2 border-rose-500/50">
          <p class="label-micro mb-1">Prejuízos (Calotes)</p>
          <h3 id="dash_pendente" class="text-2xl font-black text-white mono">R$ 0,00</h3>
        </div>
        <div class="stat-card border-b-2 border-amber-500/50">
          <p class="label-micro mb-1">Custos Insumos</p>
          <h3 id="dash_gastos" class="text-2xl font-black text-white mono">R$ 0,00</h3>
        </div>
        <div class="stat-card bg-amber-400 border-none shadow-xl shadow-amber-400/10">
          <p class="label-micro mb-1 !text-slate-800 italic">Lucro Líquido</p>
          <h3 id="dash_lucro" class="text-2xl font-black text-slate-950 mono">R$ 0,00</h3>
        </div>
      </div>
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-12 space-y-6">
          <div class="bg-slate-900/50 p-6 rounded-3xl border border-slate-800">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
              <div class="space-y-1">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                  <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                  TERMINAL DE FLUXO (MARKET DATA)
                </h4>
                <div id="fluxo_growth" class="text-xs font-bold text-emerald-400 flex items-center gap-1">
                  Crescimento: 0.0%
                </div>
              </div>
              <div class="flex flex-wrap items-center gap-4">
                <div class="flex bg-black/40 p-1 rounded-xl border border-slate-700">
                  <span onclick="toggleFilter('entrada')" id="f-entrada"
                    class="chart-filter-pill filter-on text-emerald-400"><span
                      class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Entradas</span>
                  <span onclick="toggleFilter('saida')" id="f-saida"
                    class="chart-filter-pill filter-on text-rose-400"><span
                      class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>Saídas</span>
                  <span onclick="toggleFilter('lucro')" id="f-lucro"
                    class="chart-filter-pill filter-on text-white"><span
                      class="w-1.5 h-1.5 rounded-full bg-white"></span>Lucro</span>
                  <span onclick="toggleFilter('prejuizo')" id="f-prejuizo"
                    class="chart-filter-pill filter-on text-rose-700"><span
                      class="w-1.5 h-1.5 rounded-full bg-rose-700"></span>Prejuízo</span>
                </div>
                <!-- REMOVIDO O '4S' -->
                <div class="flex bg-black/40 p-1 rounded-xl border border-slate-700">
                  <button onclick="setPeriod('1D')" id="p-1D"
                    class="px-3 py-1.5 rounded-lg text-[9px] uppercase font-black text-slate-500">1D</button>
                  <button onclick="setPeriod('5D')" id="p-5D"
                    class="px-3 py-1.5 rounded-lg text-[9px] uppercase font-black text-slate-500">5D</button>
                  <button onclick="setPeriod('mes')" id="p-mes"
                    class="px-3 py-1.5 rounded-lg text-[9px] uppercase font-black text-slate-500 active-period">1M</button>
                  <button onclick="setPeriod('ano')" id="p-ano"
                    class="px-3 py-1.5 rounded-lg text-[9px] uppercase font-black text-slate-500">1A</button>
                  <button onclick="setPeriod('5A')" id="p-5A"
                    class="px-3 py-1.5 rounded-lg text-[9px] uppercase font-black text-slate-500">5A</button>
                  <button onclick="setPeriod('MAX')" id="p-MAX"
                    class="px-3 py-1.5 rounded-lg text-[9px] uppercase font-black text-slate-500">MAX</button>
                </div>
              </div>
            </div>
            <div class="h-[400px] w-full"><canvas id="grafico_principal"></canvas></div>
          </div>
        </div>
        <div class="lg:col-span-6 stat-card bg-gradient-to-br from-slate-900 to-black">
          <h4 class="label-micro !text-purple-400 mb-5">Retiradas Pessoais</h4>
          <div class="space-y-2">
            <p class="label-micro opacity-50">Total Retirado no Período</p>
            <h3 id="dash_pessoal_total" class="text-2xl font-black text-white mono">R$ 0,00</h3>
          </div>
        </div>
        <div class="lg:col-span-6 bg-slate-900/50 p-6 rounded-3xl border border-slate-800">
          <h4 class="label-micro mb-6">Eficiência de Gastos</h4>
          <div class="h-[200px]"><canvas id="grafico_rosca"></canvas></div>
        </div>
      </div>
    </section>

    <!-- ── VENDAS  ─────────────────────────────── -->
    <section id="caixa" class="tab-content space-y-6">
      <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Gestão de Vendas</h2>
          <p class="text-slate-400 text-sm mt-1">Registre e acompanhe todas as movimentações de entrada.</p>
        </div>
        <div class="flex flex-wrap gap-4">
          <div class="bg-emerald-500/10 px-4 py-2 rounded-xl border border-emerald-500/20">
            <p class="label-micro text-emerald-400">Total Recebido</p>
            <p id="vendas_recebido" class="text-lg font-black mono text-white">R$ 0,00</p>
          </div>
          <div class="bg-amber-500/10 px-4 py-2 rounded-xl border border-amber-500/20">
            <p class="label-micro text-amber-400">Total Pendente</p>
            <p id="vendas_pendente_total" class="text-lg font-black mono text-white">R$ 0,00</p>
          </div>
          <div class="bg-rose-500/10 px-4 py-2 rounded-xl border border-rose-500/20">
            <p class="label-micro text-rose-400">Total Calote</p>
            <p id="vendas_calote_total" class="text-lg font-black mono text-white">R$ 0,00</p>
          </div>
        </div>
      </div>

      <!-- Formulário -->
      <div class="bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-800 shadow-xl">
        <form onsubmit="adicionarVenda(event)" class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-8 gap-5 items-end">
          <div class="md:col-span-1"><label class="label-micro block mb-3">Data</label> <input id="v_data" type="date"
              required class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-1"><label class="label-micro block mb-3">Hora</label> <input id="v_hora" type="time"
              required class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-1 lg:col-span-2"><label class="label-micro block mb-3">Cliente</label> <input
              id="v_cli" type="text" required placeholder="Nome do cliente" class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-1 lg:col-span-2"><label class="label-micro block mb-3">Item / Serviço</label> <input
              id="v_prod" type="text" required placeholder="O que foi vendido?" class="w-full h-11 px-4 rounded-xl">
          </div>
          <div class="md:col-span-1"><label class="label-micro block mb-3">Quantidade</label> <input id="v_qtd"
              type="number" value="1" min="1" class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-1"><label class="label-micro block mb-3">Valor Unit.</label><input id="v_val"
              type="number" step="0.01" required placeholder="0.00" class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-1 lg:col-span-2">
            <label class="label-micro block mb-3">Status</label>
            <select id="v_sta" class="w-full h-11 px-4 rounded-xl text-sm">
              <option value="Pago">Pago</option>
              <option value="Pendente">Pendente</option>
              <option value="Calote">Calote</option>
            </select>
          </div>
          <button type="submit"
            class="h-11 bg-amber-400 text-slate-900 font-black rounded-xl uppercase text-[11px] hover:bg-amber-300 transition-all md:col-span-4 lg:col-span-2">Registrar
            Venda</button>
        </form>
      </div>

      <!-- Barra de Pesquisa Integrada -->
      <div class="flex items-center gap-3 search-bar-container px-4 py-3 rounded-2xl w-full md:w-96 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar por cliente, item ou status..."
          onkeyup="filtrarTabela('lista_vendas', this.value)"
          class="bg-transparent border-none text-sm text-white focus:outline-none w-full !bg-transparent !border-0 p-0">
      </div>

      <!-- Tabela -->
      <div class="bg-slate-900/40 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-900">
              <tr>
                <th class="px-6 py-5 label-micro">Data/Hora</th>
                <th class="px-6 py-5 label-micro">Cliente</th>
                <th class="px-6 py-5 label-micro">Item</th>
                <th class="px-6 py-5 label-micro text-center">Quantidade</th>
                <th class="px-6 py-5 label-micro text-right">Valor</th>
                <th class="px-6 py-5 label-micro text-center">Status</th>
                <th class="px-6 py-5 text-right">Ação</th>
              </tr>
            </thead>
            <tbody id="lista_vendas" class="divide-y divide-slate-800/50 transition-all"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ── CUSTOS (Melhorada com Pesquisa) ─────────────────────────────── -->
    <section id="gastos" class="tab-content space-y-6">
      <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Custos com Insumos</h2>
          <p class="text-slate-400 text-sm mt-1">Controle suas despesas operacionais e matérias-primas.</p>
        </div>
        <div class="bg-rose-500/10 px-4 py-2 rounded-xl border border-rose-500/20">
          <p class="label-micro text-rose-400">Total Gasto</p>
          <p id="gastos_total" class="text-lg font-black mono text-white">R$ 0,00</p>
        </div>
      </div>
      <div class="bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-800 shadow-xl">
        <form onsubmit="adicionarGasto(event)" class="grid grid-cols-1 md:grid-cols-5 gap-5 items-end">
          <div><label class="label-micro block mb-3">Data</label> <input id="g_data" type="date" required
              class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-2"><label class="label-micro block mb-3">Descrição</label> <input id="g_desc"
              type="text" required placeholder="O que foi comprado?" class="w-full h-11 px-4 rounded-xl"></div>
          <div>
            <label class="label-micro block mb-3">Categoria</label>
            <select id="g_cat" class="w-full h-11 px-4 rounded-xl text-sm">
              <option>Matéria-prima</option>
              <option>Embalagem</option>
              <option>Limpeza</option>
              <option>Manutenção</option>
              <option>Outros</option>
            </select>
          </div>
          <div><label class="label-micro block mb-3">Valor</label> <input id="g_val" type="number" step="0.01" required
              placeholder="0.00" class="w-full h-11 px-4 rounded-xl"></div>
          <button type="submit"
            class="h-11 bg-rose-500 text-white font-black rounded-xl uppercase text-[11px] hover:bg-rose-400 transition-all md:col-span-5">Registrar
            Despesa</button>
        </form>
      </div>

      <div class="flex items-center gap-3 search-bar-container px-4 py-3 rounded-2xl w-full md:w-96 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar despesa..." onkeyup="filtrarTabela('lista_gastos', this.value)"
          class="bg-transparent border-none text-sm text-white focus:outline-none w-full !bg-transparent !border-0 p-0">
      </div>

      <div class="bg-slate-900/40 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-900">
              <tr>
                <th class="px-6 py-5 label-micro">Data</th>
                <th class="px-6 py-5 label-micro">Descrição</th>
                <th class="px-6 py-5 label-micro">Categoria</th>
                <th class="px-6 py-5 label-micro text-right">Valor</th>
                <th class="px-6 py-5 text-right">Ação</th>
              </tr>
            </thead>
            <tbody id="lista_gastos" class="divide-y divide-slate-800/50"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ── PESSOAL (Melhorada com Pesquisa) ────────────────────────────── -->
    <section id="pessoal" class="tab-content space-y-6">
      <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Retiradas Pessoais</h2>
          <p class="text-slate-400 text-sm mt-1">Controle de pagamentos aos sócios e funcionários.</p>
        </div>
        <div class="bg-purple-500/10 px-4 py-2 rounded-xl border border-purple-500/20">
          <p class="label-micro text-purple-400">Total Retirado</p>
          <p id="pessoal_total" class="text-lg font-black mono text-white">R$ 0,00</p>
        </div>
      </div>
      <div class="bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-800 shadow-xl">
        <form onsubmit="adicionarPessoal(event)" class="grid grid-cols-1 md:grid-cols-5 gap-5 items-end">
          <div><label class="label-micro block mb-3">Data</label> <input id="p_data" type="date" required
              class="w-full h-11 px-4 rounded-xl"></div>
          <div><label class="label-micro block mb-3">Nome</label> <input id="p_nome" type="text" required
              placeholder="Quem recebeu?" class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-2"><label class="label-micro block mb-3">Descrição</label> <input id="p_desc"
              type="text" required placeholder="Motivo/Referência" class="w-full h-11 px-4 rounded-xl"></div>
          <div><label class="label-micro block mb-3">Valor</label> <input id="p_val" type="number" step="0.01" required
              placeholder="0.00" class="w-full h-11 px-4 rounded-xl"></div>
          <button type="submit"
            class="h-11 bg-purple-500 text-white font-black rounded-xl uppercase text-[11px] hover:bg-purple-400 transition-all md:col-span-5">Registrar
            Pagamento</button>
        </form>
      </div>

      <div class="flex items-center gap-3 search-bar-container px-4 py-3 rounded-2xl w-full md:w-96 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar pessoa ou descrição..."
          onkeyup="filtrarTabela('lista_pessoal', this.value)"
          class="bg-transparent border-none text-sm text-white focus:outline-none w-full !bg-transparent !border-0 p-0">
      </div>

      <div class="bg-slate-900/40 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-900">
              <tr>
                <th class="px-6 py-5 label-micro">Data</th>
                <th class="px-6 py-5 label-micro">Nome</th>
                <th class="px-6 py-5 label-micro">Descrição</th>
                <th class="px-6 py-5 label-micro text-right">Valor</th>
                <th class="px-6 py-5 text-right">Ação</th>
              </tr>
            </thead>
            <tbody id="lista_pessoal" class="divide-y divide-slate-800/50"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ── ESTOQUE (NOVA ABA) ────────────────────────────────── -->
    <section id="estoque" class="tab-content space-y-6">
      <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Controle de Estoque</h2>
          <p class="text-slate-400 text-sm mt-1">Gerencie quantidades e receba alertas de itens baixos.</p>
        </div>
        <div class="bg-sky-500/10 px-4 py-2 rounded-xl border border-sky-500/20">
          <p class="label-micro text-sky-400">Capital Imobilizado</p>
          <p id="estoque_total" class="text-lg font-black mono text-white">R$ 0,00</p>
        </div>
      </div>

      <div class="bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-800 shadow-xl">
        <form onsubmit="adicionarEstoque(event)" class="grid grid-cols-1 md:grid-cols-6 gap-5 items-end">
          <div class="md:col-span-2"><label class="label-micro block mb-3">Item do Estoque</label><input id="e_nome"
              type="text" required placeholder="Nome do produto" class="w-full h-11 px-4 rounded-xl"></div>
          <div>
            <label class="label-micro block mb-3">Categoria</label>
            <select id="e_cat" class="w-full h-11 px-4 rounded-xl text-sm">
              <option>Insumos</option>
              <option>Embalagens</option>
              <option>Revenda</option>
              <option>Uso Interno</option>
            </select>
          </div>
          <div><label class="label-micro block mb-3">Qtd. Atual</label> <input id="e_qtd" type="number" required min="0"
              class="w-full h-11 px-4 rounded-xl"></div>
          <div><label class="label-micro block mb-3">Estoque Mín.</label><input id="e_min" type="number" required
              min="1" class="w-full h-11 px-4 rounded-xl"></div>
          <div><label class="label-micro block mb-3">Valor Ref. (Un)</label> <input id="e_val" type="number" step="0.01"
              required placeholder="0.00" class="w-full h-11 px-4 rounded-xl"></div>
          <button type="submit"
            class="h-11 bg-sky-500 text-white font-black rounded-xl uppercase text-[11px] hover:bg-sky-400 transition-all md:col-span-6">Adicionar
            ao Estoque</button>
        </form>
      </div>

      <div class="flex items-center gap-3 search-bar-container px-4 py-3 rounded-2xl w-full md:w-96 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar no estoque..." onkeyup="filtrarTabela('lista_estoque', this.value)"
          class="bg-transparent border-none text-sm text-white focus:outline-none w-full !bg-transparent !border-0 p-0">
      </div>

      <div class="bg-slate-900/40 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-900">
              <tr>
                <th class="px-6 py-5 label-micro">Item</th>
                <th class="px-6 py-5 label-micro">Categoria</th>
                <th class="px-6 py-5 label-micro text-center">Quantidade</th>
                <th class="px-6 py-5 label-micro text-center">Estoque Mínimo</th>
                <th class="px-6 py-5 label-micro text-right">Valor em Estoque</th>
                <th class="px-6 py-5 label-micro text-center">Status</th>
                <th class="px-6 py-5 text-right">Ação</th>
              </tr>
            </thead>
            <tbody id="lista_estoque" class="divide-y divide-slate-800/50"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ── CAIXINHAS (NOVA ABA - ESTILO NUBANK) ────────────────────────── -->
    <section id="caixinhas" class="tab-content space-y-8">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Caixinhas</h2>
          <p class="text-slate-400 text-sm mt-1">Organize seu dinheiro por objetivos (Estilo Nubank).</p>
        </div>
        <button onclick="document.getElementById('form_caixinha').classList.toggle('hidden')"
          class="bg-purple-600 hover:bg-purple-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-purple-500/20">
          + Criar Nova Caixinha
        </button>
      </div>

      <!-- Form Criar Caixinha (Oculto por padrão) -->
      <div id="form_caixinha" class="hidden bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-800 shadow-xl mb-6">
        <form onsubmit="criarCaixinha(event)" class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
          <div class="md:col-span-2"><label class="label-micro block mb-3">Nome do Objetivo</label><input id="cx_nome"
              type="text" required placeholder="Ex: Reserva de Emergência, Reforma..."
              class="w-full h-11 px-4 rounded-xl border border-slate-700"></div>
          <div><label class="label-micro block mb-3">Meta (Valor desejado)</label><input id="cx_meta" type="number"
              step="0.01" required placeholder="R$ 10000,00"
              class="w-full h-11 px-4 rounded-xl border border-slate-700"></div>
          <div><label class="label-micro block mb-3">Saldo Inicial</label><input id="cx_saldo" type="number" step="0.01"
              value="0" class="w-full h-11 px-4 rounded-xl border border-slate-700"></div>
          <button type="submit"
            class="h-11 bg-purple-600 text-white font-black rounded-xl uppercase text-[11px] hover:bg-purple-500 transition-all md:col-span-4">Salvar
            Caixinha</button>
        </form>
      </div>

      <!-- Grid de Caixinhas -->
      <div id="grid_caixinhas" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Gerado via JS -->
      </div>
    </section>

    <!-- ── HISTÓRICO (Melhorada com Pesquisa) ──────────────────────────── -->
    <section id="historico" class="tab-content space-y-6">
      <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Histórico Completo</h2>
          <p class="text-slate-400 text-sm mt-1">Timeline de todas as transações financeiras.</p>
        </div>
      </div>

      <div class="flex items-center gap-3 search-bar-container px-4 py-3 rounded-2xl w-full md:w-96 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar no histórico geral..."
          onkeyup="filtrarTabela('lista_historico', this.value)"
          class="bg-transparent border-none text-sm text-white focus:outline-none w-full !bg-transparent !border-0 p-0">
      </div>

      <div class="bg-slate-900/30 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-900">
              <tr>
                <th class="px-6 py-5 label-micro">Data/Hora</th>
                <th class="px-6 py-5 label-micro">Tipo</th>
                <th class="px-6 py-5 label-micro">Descrição</th>
                <th class="px-6 py-5 label-micro text-right">Valor</th>
              </tr>
            </thead>
            <tbody id="lista_historico" class="divide-y divide-slate-800/50"></tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- ── RESERVAS (Melhorada com Pesquisa) ───────────────────────────── -->
    <section id="reservas" class="tab-content space-y-6">
      <div class="flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
          <h2 class="text-3xl font-black text-white">Agendamentos e Reservas</h2>
          <p class="text-slate-400 text-sm mt-1">Gerencie a agenda e os horários dos seus clientes.</p>
        </div>
      </div>

      <div class="bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-800 shadow-xl">
        <form onsubmit="adicionarReserva(event)" class="grid grid-cols-1 md:grid-cols-6 gap-5 items-end">
          <div><label class="label-micro block mb-3">Data</label> <input id="r_data" type="date" required
              class="w-full h-11 px-4 rounded-xl"></div>
          <div><label class="label-micro block mb-3">Hora</label> <input id="r_hora" type="time" required
              class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-2"><label class="label-micro block mb-3">Cliente</label> <input id="r_cli" type="text"
              required placeholder="Nome do cliente" class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-2"><label class="label-micro block mb-3">Serviço/Assunto</label> <input id="r_serv"
              type="text" required placeholder="Ex: Manutenção..." class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-4"><label class="label-micro block mb-3">Observações</label> <input id="r_obs"
              type="text" placeholder="Detalhes extras..." class="w-full h-11 px-4 rounded-xl"></div>
          <div class="md:col-span-2">
            <label class="label-micro block mb-3">Status</label>
            <select id="r_sta" class="w-full h-11 px-4 rounded-xl text-sm">
              <option value="Confirmada">Confirmada</option>
              <option value="Pendente">Pendente</option>
              <option value="Cancelada">Cancelada</option>
            </select>
          </div>
          <button type="submit"
            class="h-11 bg-emerald-500 text-white font-black rounded-xl uppercase text-[11px] hover:bg-emerald-400 transition-all md:col-span-6">Agendar
            Reserva</button>
        </form>
      </div>

      <div class="flex items-center gap-3 search-bar-container px-4 py-3 rounded-2xl w-full md:w-96 shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input type="text" placeholder="Buscar reserva por cliente, data ou serviço..."
          onkeyup="filtrarTabela('lista_reservas', this.value)"
          class="bg-transparent border-none text-sm text-white focus:outline-none w-full !bg-transparent !border-0 p-0">
      </div>

      <div class="bg-slate-900/40 rounded-3xl border border-slate-800 overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left">
            <thead class="bg-slate-900">
              <tr>
                <th class="px-6 py-5 label-micro">Data/Hora</th>
                <th class="px-6 py-5 label-micro">Cliente</th>
                <th class="px-6 py-5 label-micro">Serviço</th>
                <th class="px-6 py-5 label-micro">Obs.</th>
                <th class="px-6 py-5 label-micro text-center">Status</th>
                <th class="px-6 py-5 text-right">Ação</th>
              </tr>
            </thead>
            <tbody id="lista_reservas" class="divide-y divide-slate-800/50"></tbody>
          </table>
        </div>
      </div>
    </section>

  </main>

  <!-- JS Externo -->
  <script src="assets/js/app.js"></script>
  <script src="assets/js/resumo.js"></script>
  <script src="assets/js/vendas.js"></script>
  <script src="assets/js/gastos.js"></script>
  <script src="assets/js/pessoal.js"></script>
  <script src="assets/js/estoque.js"></script>
  <script src="assets/js/caixinhas.js"></script>
  <script src="assets/js/historico.js"></script>
  <script src="assets/js/reservas.js"></script>
</body>
</body>

</html>
