<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GP Casale | Gestão Operacional Definitiva</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="text-slate-200">

  <nav class="glass-nav sticky top-0 z-50 px-4 py-2">
    <div class="max-w-7xl w-full flex flex-col md:flex-row justify-between items-center gap-4">
      <div class="flex items-center gap-3">
        <div class="bg-amber-400 p-2.5 rounded-xl"><span class="text-slate-900 font-black text-xl italic">GP</span></div>
        <div>
          <h1 class="text-lg font-black tracking-tighter text-white leading-tight">CASALE <span class="text-amber-400">PRO</span></h1>
          <div id="status-loja-nav" class="label-micro flex items-center mt-0.5 opacity-50">SINCRONIZANDO...</div>
        </div>
      </div>
      
      <div class="flex items-center gap-1 bg-black/20 p-1 rounded-2xl border border-white/5 overflow-x-auto w-full md:w-auto">
        <button onclick="switchTab('resumo')" class="nav-btn text-[10px] font-bold uppercase active-resumo" id="btn-resumo">Resumo</button>
        <button onclick="switchTab('caixa')" class="nav-btn text-[10px] font-bold uppercase" id="btn-caixa">Vendas</button>
        <button onclick="switchTab('gastos')" class="nav-btn text-[10px] font-bold uppercase" id="btn-gastos">Custos</button>
        <button onclick="switchTab('pessoal')" class="nav-btn text-[10px] font-bold uppercase" id="btn-pessoal">Pessoal</button>
        <button onclick="switchTab('estoque')" class="nav-btn text-[10px] font-bold uppercase" id="btn-estoque">Estoque</button>
        <button onclick="switchTab('caixinhas')" class="nav-btn text-[10px] font-bold uppercase" id="btn-caixinhas">Caixinhas</button>
        <button onclick="switchTab('historico')" class="nav-btn text-[10px] font-bold uppercase" id="btn-historico">Histórico</button>
        <button onclick="switchTab('reservas')" class="nav-btn text-[10px] font-bold uppercase" id="btn-reservas">Reservas</button>
      </div>
    </div>
  </nav>

  <main class="max-w-7xl w-full p-4 md:p-8 space-y-8">
    <?php 
      include 'views/resumo.php';
      include 'views/vendas.php';
      include 'views/gastos.php';
      include 'views/pessoal.php';
      include 'views/estoque.php';
      include 'views/caixinhas.php';
      include 'views/historico.php';
      include 'views/reservas.php';
    ?>
  </main>

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
</html>
