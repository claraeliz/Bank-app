<?php
require_once 'includes/bootstrap.php';

if ($selectedIdx === null) {
    header('Location: index.php');
    exit;
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = (float) $_POST['amount'];

    if ($amount <= 0) {
        $message = ['type' => 'error', 'text' => 'Please enter a valid amount.'];
    } elseif ($amount > $wallet->getBalance()) {
        $message = ['type' => 'error', 'text' => 'Insufficient funds in your wallet.'];
    } else {
        $wallet->transfer($amount, $account);
        saveSession($accounts, $cards, $wallets);
        $message = ['type' => 'success', 'text' => '€' . number_format($amount, 2) . ' deposited from your wallet.'];
    }
}

require_once 'includes/header.php';
?>

<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Deposit Funds</h1>

    <?php if ($message): ?>
        <div class="mb-6 px-4 py-3 rounded-xl text-sm font-medium
            <?= $message['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $message['text'] ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow p-6">

        <div class="flex justify-between mb-6">
            <div>
                <p class="text-sm text-slate-500 mb-1">Wallet Balance</p>
                <p class="text-2xl font-bold text-slate-800">€<?= number_format($wallet->getBalance(), 2) ?></p>
                <p class="text-xs text-slate-400 mt-1"><?= htmlspecialchars($wallet->getOwner()->getName()) ?></p>
            </div>
            <div class="text-slate-300 text-2xl self-center">→</div>
            <div class="text-right">
                <p class="text-sm text-slate-500 mb-1">Main Account</p>
                <p class="text-2xl font-bold text-slate-800">€<?= number_format($account->getBalance(), 2) ?></p>
                <p class="text-xs text-slate-400 mt-1"><?= htmlspecialchars($account->getOwner()->getName()) ?></p>
            </div>
        </div>

        <form method="POST">
            <label class="block text-sm font-medium text-slate-700 mb-1">Amount (€)</label>
            <input type="number" name="amount" min="0.01" step="0.01" placeholder="0.00"
                   max="<?= $wallet->getBalance() ?>"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-violet-400 mb-4">
            <button type="submit"
                    class="w-full bg-violet-600 hover:bg-violet-700 text-white font-semibold py-3 rounded-xl transition">
                Deposit from Wallet
            </button>
        </form>
    </div>

    <a href="index.php" class="block text-center text-sm text-slate-400 hover:text-slate-600 mt-4">← Back to Dashboard</a>
</div>

<?php require_once 'includes/footer.php'; ?>
