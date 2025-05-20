<div id="deleteSuccess" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-sm text-center animate-fadeIn">
        <i class="fa-solid fa-check-circle text-green-600 text-4xl mb-2"></i>
        <h2 class="text-green-600 text-lg font-bold mb-1">Berhasil!</h2>
        <p class="text-sm text-slate-700">Data berhasil dihapus.</p>
    </div>
</div>


<script>
function showDelete(id) {
    const successModal = document.getElementById(id);
    successModal.classList.remove('hidden');
    setTimeout(() => {
        successModal.classList.add('hidden');
    }, 2000);
}
</script>
