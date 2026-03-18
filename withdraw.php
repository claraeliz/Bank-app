<?php
require_once 'includes/bootstrap.php';

if ($selectedIdx === null) {
    header('Location: index.php');
    exit;
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount        = (float) $_POST['amount'];
    $balanceBefore = $account->getBalance();

    if ($amount > 0) {
        $account->withdraw($amount);
        if ($account->getBalance() < $balanceBefore) {
            saveSession($accounts, $cards, $wallets);
            $message = ['type' => 'success', 'text' => '€' . number_format($amount, 2) . ' withdrawn successfully.'];
        } else {
            $message = ['type' => 'error', 'text' => 'Insufficient funds.'];
        }
    } else {
        $message = ['type' => 'error', 'text' => 'Please enter a valid amount.'];
    }
}

require_once 'includes/header.php';
?>

<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Withdraw Funds</h1>

    <?php if ($message): ?>
        <div class="mb-6 px-4 py-3 rounded-xl text-sm font-medium
            <?= $message['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $message['text'] ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow p-6">
        <p class="text-sm text-slate-500 mb-1">Current Balance</p>
        <p class="text-3xl font-bold text-slate-800 mb-6">€<?= number_format($account->getBalance(), 2) ?></p>

        <form method="POST">
            <label class="block text-sm font-medium text-slate-700 mb-1">Amount (€)</label>
            <input type="number" name="amount" min="0.01" step="0.01" placeholder="0.00"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-violet-400 mb-4">
            <button type="submit"
                    class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-3 rounded-xl transition">
                Withdraw
            </button>
        </form>
    </div>

    <a href="index.php" class="block text-center text-sm text-slate-400 hover:text-slate-600 mt-4">← Back to Dashboard</a>
</div>

<?php require_once 'includes/footer.php'; ?>
