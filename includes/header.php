<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BankApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen">

<nav class="bg-slate-900 text-white px-8 py-4 flex items-center justify-between">
    <a href="index.php" class="text-xl font-bold tracking-tight">BankApp</a>
    <div class="flex gap-6 text-sm font-medium">
        <a href="index.php"    class="hover:text-slate-300 transition">Dashboard</a>
        <a href="deposit.php"  class="hover:text-slate-300 transition">Deposit</a>
        <a href="withdraw.php" class="hover:text-slate-300 transition">Withdraw</a>
        <a href="transfer.php" class="hover:text-slate-300 transition">Transfer</a>
        <a href="reset.php"    class="hover:text-red-400 transition text-slate-400">Reset</a>
    </div>
</nav>

<main class="max-w-4xl mx-auto px-6 py-10">
