<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@verbatim
<script >


    // === Grafik Transaksi ===
    new Chart(document.getElementById('transaksiChart'), {
        type: 'line',
        data: {
            labels: transaksiData.map(item => 'Bulan ' + item.bulan),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: transaksiData.map(item => item.total),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.3,
            }]
        },
    });

    // === Grafik Produk Terlaris ===
    new Chart(document.getElementById('produkChart'), {
        type: 'bar',
        data: {
            labels: produkData.map(item => item.nama),
            datasets: [{
                label: 'Total Terjual',
                data: produkData.map(item => item.total),
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
            }]
        },
    });
</script>
@endverbatim