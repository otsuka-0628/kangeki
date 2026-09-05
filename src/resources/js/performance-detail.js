
document.addEventListener('DOMContentLoaded', () => {
    const copyBtn = document.getElementById('copyUrlBtn');


    if (copyBtn) {
        copyBtn.addEventListener('click', () => {
            const urlInput = document.getElementById('reservationUrlInput');
            if (!urlInput) return;


            urlInput.select();
            navigator.clipboard.writeText(urlInput.value)
                .then(() => {
                    alert('予約フォームのURLをコピーしました！');
                })
                .catch(err => {
                    console.error('コピーに失敗しました:', err);
                });
        });
    }
});