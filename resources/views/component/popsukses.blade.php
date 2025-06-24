<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white p-8 rounded-lg shadow-md text-center max-w-sm w-full">
      <i class="fa fa-check-circle text-green-600 text-4xl mb-2"></i>
        <h3 class="text-green-600 font-semibold text-lg mb-2">Berhasil!</h3>
        <p id="successMessage" class="text-sm text-slate-700"></p>
    </div>
</div>

<script>
    function showSuccess(message) {
        document.getElementById("successMessage").textContent = message;
        const modal = document.getElementById("successModal");
        modal.classList.remove("hidden");
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 2000);
    }
</script>