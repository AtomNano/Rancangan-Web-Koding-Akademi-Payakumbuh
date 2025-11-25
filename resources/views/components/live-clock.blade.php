<div class="flex items-center space-x-2 text-slate-600">
    <svg class="w-5 h-5 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span id="live-clock" class="font-medium" x-data="liveClock()" x-init="init()" x-text="time"></span>
</div>

<script>
function liveClock() {
    return {
        time: new Date().toLocaleString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'Asia/Jakarta'
        }),
        init() {
            setInterval(() => {
                this.time = new Date().toLocaleString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    timeZone: 'Asia/Jakarta'
                });
            }, 1000);
        }
    }
}
</script>
