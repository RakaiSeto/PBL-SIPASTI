<div id="gagalModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-lg shadow-md text-center max-w-sm w-full">
      <i class="fa-solid fa-xmark-circle text-red-600 text-4xl mb-2"></i>
        <h3 class="text-red-600 font-semibold text-lg mb-2">hapus</h3>
        <p id="gagalMessage" class="text-sm text-slate-700"></p>
    </div>
</div>

<script>
    function showGagal(message) {
        document.getElementById("gagalMessage").textContent = message;
        const modal = document.getElementById("gagalModal");
        modal.classList.remove("hidden");
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 2000);
    }
</script>