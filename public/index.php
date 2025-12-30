<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexCurrency | Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <h2><i class="fa-solid fa-money-bill-trend-up" style="color:var(--primary)"></i> NexCurrency</h2>
    
    <div class="input-group">
        <label>Miktar</label>
        <input type="number" id="amount" value="1" step="0.01" oninput="convert()">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
        <div class="input-group">
            <label>Nereden</label>
            <select id="fromCurrency" onchange="convert()">
                <option value="TRY">TRY - TL</option>
                <option value="USD" selected>USD - Dolar</option>
                <option value="EUR">EUR - Euro</option>
                <option value="GBP">GBP - Sterlin</option>
                <option value="BTC">BTC - Bitcoin</option>
            </select>
        </div>
        <div class="input-group">
            <label>Nereye</label>
            <select id="toCurrency" onchange="convert()">
                <option value="TRY" selected>TRY - TL</option>
                <option value="USD">USD - Dolar</option>
                <option value="EUR">EUR - Euro</option>
                <option value="JPY">JPY - Yen</option>
                <option value="KWD">KWD - Kuveyt Dinarı</option>
            </select>
        </div>
    </div>

    <div id="result-box">
        <div class="loader" id="loader"></div>
        <div id="result-content">Hesaplanıyor...</div>
    </div>
</div>

<script>
let timeout = null;

async function convert() {
    const amount = document.getElementById('amount').value;
    const from = document.getElementById('fromCurrency').value;
    const to = document.getElementById('toCurrency').value;
    const resultContent = document.getElementById('result-content');
    const loader = document.getElementById('loader');

    if (!amount || amount <= 0) {
        resultContent.innerHTML = "Miktar giriniz";
        return;
    }

    clearTimeout(timeout);
    timeout = setTimeout(async () => {
        loader.style.display = 'block';
        resultContent.style.display = 'none';

        try {
            const response = await fetch(`api.php?amount=${amount}&from=${from}&to=${to}`);
            const data = await response.json();

            loader.style.display = 'none';
            resultContent.style.display = 'block';

            if(data.error) {
                resultContent.innerHTML = "Hata oluştu";
            } else {
                resultContent.innerHTML = `
                    <div class="amount-text">${data.sonuc} ${data.birim_e}</div>
                    <div class="rate-text">1 ${data.birim_den} = ${data.kur} ${data.birim_e}</div>
                `;
            }
        } catch (err) {
            loader.style.display = 'none';
            resultContent.style.display = 'block';
            resultContent.innerHTML = "Bağlantı kesildi";
        }
    }, 300);
}

window.onload = convert;
</script>

</body>
</html>