document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. 開演日時 & 日時別座席数の追加・削除連動
    // ==========================================
    const addScheduleBtn = document.getElementById('add-schedule-btn');
    const scheduleContainer = document.getElementById('schedule-container');
    const seatContainer = document.getElementById('seat-container');

    if (addScheduleBtn && scheduleContainer && seatContainer) {

        // 【追加ボタン】
        addScheduleBtn.addEventListener('click', function () {
            const index = scheduleContainer.querySelectorAll('.schedule-item').length;

            // 開演日時の入力項目を追加
            const newSchedule = document.createElement('div');
            newSchedule.className = 'schedule-item dynamic-item';
            newSchedule.setAttribute('data-index', index);
            newSchedule.innerHTML = `
                <input type="datetime-local" class="schedule-input form-control" name="schedules[${index}][start_at]">
                <button type="button" class="btn-remove remove-schedule-btn">削除</button>
            `;
            scheduleContainer.appendChild(newSchedule);

            // 日時別座席数の入力項目を連動追加
            const newSeat = document.createElement('div');
            newSeat.className = 'seat-item dynamic-item';
            newSeat.setAttribute('data-index', index);
            newSeat.innerHTML = `
                <label class="seat-label sub-label">【開演日時 ${index + 1}】</label>
                <input type="number" name="schedules[${index}][capacity]" placeholder="例：50" class="form-control">
            `;
            seatContainer.appendChild(newSeat);
        });

        // 【削除ボタン（親要素のイベント委任で処理）】
        scheduleContainer.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-schedule-btn')) {
                const item = e.target.closest('.schedule-item');
                const index = item.getAttribute('data-index');

                // 対応する座席数欄も探して削除
                const seatItem = seatContainer.querySelector(`.seat-item[data-index="${index}"]`);
                if (seatItem) {
                    seatItem.remove();
                }
                item.remove();

                // インデックス番号の振り直し
                reindexSchedules();
            }
        });
    }

    // 開演日時のインデックス振り直し関数
    function reindexSchedules() {
        const scheduleItems = scheduleContainer.querySelectorAll('.schedule-item');
        const seatItems = seatContainer.querySelectorAll('.seat-item');

        scheduleItems.forEach((item, idx) => {
            item.setAttribute('data-index', idx);
            const input = item.querySelector('input');
            if (input) input.name = `schedules[${idx}][start_at]`;
        });

        seatItems.forEach((item, idx) => {
            item.setAttribute('data-index', idx);
            const label = item.querySelector('.seat-label');
            if (label) label.textContent = `【開演日時 ${idx + 1}】`;
            const input = item.querySelector('input');
            if (input) input.name = `schedules[${idx}][capacity]`;
        });
    }


    // ==========================================
    // 2. チケット種類 & チケット料金の追加・削除連動
    // ==========================================
    const addTicketBtn = document.getElementById('add-ticket-btn');
    const ticketTypeContainer = document.getElementById('ticket-type-container');
    const ticketFeeContainer = document.getElementById('ticket-fee-container');

    if (addTicketBtn && ticketTypeContainer && ticketFeeContainer) {

        // 【追加ボタン】
        addTicketBtn.addEventListener('click', function () {
            const index = ticketTypeContainer.querySelectorAll('.ticket-type-item').length;

            // チケット種類の入力項目を追加
            const newType = document.createElement('div');
            newType.className = 'ticket-type-item dynamic-item';
            newType.setAttribute('data-index', index);
            newType.innerHTML = `
                <input type="text" class="ticket-type-input form-control" name="tickets[${index}][name]" placeholder="例：一般、学生、前売り等">
                <button type="button" class="btn-remove remove-ticket-btn">削除</button>
            `;
            ticketTypeContainer.appendChild(newType);

            // チケット料金の入力項目を連動追加
            const newFee = document.createElement('div');
            newFee.className = 'ticket-fee-item dynamic-item';
            newFee.setAttribute('data-index', index);
            newFee.innerHTML = `
                <label class="ticket-fee-label sub-label">【チケット種類 ${index + 1}】</label>
                <div class="input-unit-wrapper">
                    <input type="number" name="tickets[${index}][price]" placeholder="例：3000" class="form-control"><span class="unit">円</span>
                </div>
            `;
            ticketFeeContainer.appendChild(newFee);
        });

        // 【削除ボタン】
        ticketTypeContainer.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-ticket-btn')) {
                const item = e.target.closest('.ticket-type-item');
                const index = item.getAttribute('data-index');

                // 対応する料金欄も探して削除
                const feeItem = ticketFeeContainer.querySelector(`.ticket-fee-item[data-index="${index}"]`);
                if (feeItem) {
                    feeItem.remove();
                }
                item.remove();

                // インデックス番号の振り直し
                reindexTickets();
            }
        });
    }

    // チケットのインデックス振り直し関数
    function reindexTickets() {
        const typeItems = ticketTypeContainer.querySelectorAll('.ticket-type-item');
        const feeItems = ticketFeeContainer.querySelectorAll('.ticket-fee-item');

        typeItems.forEach((item, idx) => {
            item.setAttribute('data-index', idx);
            const input = item.querySelector('input');
            if (input) input.name = `tickets[${idx}][name]`;
        });

        feeItems.forEach((item, idx) => {
            item.setAttribute('data-index', idx);
            const label = item.querySelector('.ticket-fee-label');
            if (label) label.textContent = `【チケット種類 ${idx + 1}】`;
            const input = item.querySelector('input');
            if (input) input.name = `tickets[${idx}][price]`;
        });
    }

});