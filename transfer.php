<?php
require_once 'includes/bootstrap.php';

if ($selectedIdx === null) {
    header('Location: index.php');
    exit;
}

$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount    = (float) $_POST['amount'];
    $targetIdx = isset($_POST['to_account']) ? (int) $_POST['to_account'] : -1;

    if ($targetIdx < 0 || $targetIdx === $selectedIdx || !isset($accounts[$targetIdx])) {
        $message = ['type' => 'error', 'text' => 'Please select a valid recipient account.'];
    } elseif ($amount <= 0) {
        $message = ['type' => 'error', 'text' => 'Please enter a valid amount.'];
    } else {
        $target        = $accounts[$targetIdx];
        $balanceBefore = $account->getBalance();

        $account->transfer($amount, $target);

        if ($account->getBalance() < $balanceBefore) {
            saveSession($accounts, $cards, $wallets);
            $message = ['type' => 'success', 'text' => '€' . number_format($amount, 2) . ' transferred to ' . htmlspecialchars($target->getOwner()->getName()) . '.'];
        } else {
            $message = ['type' => 'error', 'text' => 'Insufficient funds.'];
        }
    }
}

require_once 'includes/header.php';
?>

<div class="max-w-md mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Transfer Funds</h1>

    <?php if ($message): ?>
        <div class="mb-6 px-4 py-3 rounded-xl text-sm font-medium
            <?= $message['type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= $message['text'] ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow p-6">
        <!-- From -->
        <div class="mb-6">
            <p class="text-sm text-slate-500 mb-1">From</p>
            <p class="font-semibold text-slate-800"><?= htmlspecialchars($account->getOwner()->getName()) ?></p>
            <p class="text-sm text-slate-400">€<?= number_format($account->getBalance(), 2) ?></p>
        </div>

        <form method="POST">
            <!-- To: account selector -->
            <label class="block text-sm font-medium text-slate-700 mb-1">To</label>
            <select name="to_account"
                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-violet-400 mb-4">
                <option value="" disabled selected>Select recipient…</option>
                <?php foreach ($accounts as $idx => $acc): ?>
                    <?php if ($idx !== $selectedIdx): ?>
                        <option value="<?= $idx ?>"
                            <?= (isset($_POST['to_account']) && (int)$_POST['to_account'] === $idx) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($acc->getOwner()->getName()) ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <label class="block text-sm font-medium text-slate-700 mb-1">Amount (€)</label>
            <input type="number" name="amount" min="0.01" step="0.01" placeholder="0.00"
                   class="w-full border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-violet-400 mb-4">
            <button type="submit"
                    class="w-full bg-violet-600 hover:bg-violet-700 text-white font-semibold py-3 rounded-xl transition">
                Transfer
            </button>
        </form>
    </div>

    <a href="index.php" class="block text-center text-sm text-slate-400 hover:text-slate-600 mt-4">← Back to Dashboard</a>
</div>

<?php require_once 'includes/footer.php'; ?>
