<header class="fixed top-4 left-3 right-3 z-50 bg-transparent flex justify-between items-center py-4 px-6">

    <!-- Logo -->
    <div class="flex-shrink-0">
      <img src="{{url('images/ITA_header_logo.png');}}" alt="logo" class="scale-90">
    </div>

    <!-- Idiomas + Botón Entrar -->
    <div class="flex-grow flex justify-end items-center">

      <!-- Botón Desplegable Idiomas -->
      <div class="relative mr-10" style="border-radius: 10px; border: 1px solid #7E7E7E">
        <div class="relative" style="border-radius: 10px; border: 1px solid #7E7E7E">
          <div class="flex items-center justify-between text-2xl text-gray-500 font-bold ml-3 mr-3 px-4 py-6">
            <span>Castellano</span>
            <div class="ml-2">
              <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-down w-6 h-6">
                <path fill-rule="evenodd"
                  d="M10 13.292l-5.146-5.147a1 1 0 0 1 1.414-1.414L10 10.464l3.732-3.733a1 1 0 0 1 1.414 1.414L10 13.292z"
                  clip-rule="evenodd" />
              </svg>
            </div>
          </div>
          <!-- Tabla Idiomas (links) -->
          <ul class="absolute right-0 top-full mt-6 w-80 rounded-xl bg-white border-2 border-gray-300 hidden">
            <li class="flex items-center px-8 py-8 hover:bg-gray-200 flex-row">
              <div class="text-left flex-grow">
                <div class="rounded-full h-53 w-53 flex items-left text-gray-600 font-bold text-3xl">
                  Català
                </div>
              </div>
              <img src="{{url('images/catala.png');}}" alt="bandera Cat" class="h-53 w-53 scale-90 ml-4 flex-none">
            </li>
            <li class="flex items-center px-8 py-8 hover:bg-gray-200 border-t border-gray-300 flex-row">
              <div class="text-left flex-grow">
                <div class="rounded-full h-53 w-53 flex items-left text-gray-600 font-bold text-3xl">
                  Castellano
                </div>
              </div>
              <img src="{{url('images/castellano.png');}}" alt="bandera Esp" class="h-53 w-53 scale-90 ml-4 flex-none">
            </li>
            <li class="flex items-center px-8 py-8 hover:bg-gray-200 border-t border-gray-300 flex-row">
              <div class="text-left flex-grow">
                <div class="rounded-full h-53 w-53 flex items-left text-gray-600 font-bold text-3xl">
                  English
                </div>
              </div>
              <img src="{{url('images/english.png');}}" alt="bandera Eng" class="h-53 w-53 scale-90 ml-4 flex-none">
            </li>
          </ul>
        </div>
      </div>

      <!-- Botón Entrar -->
      <button class="bg-transparent px-4 py-6 flex items-center" style="border-radius: 10px; border: 1px solid black">
        <div class="ml-8">
          <img src="{{url('images/sel_right.png');}}" class="h-8 w-8">
        </div>
        <span class="text-black font-bold ml-6 mr-8 text-2xl">Entrar</span>
      </button>

    </div>

  </header>

  <!-- JavaScript para abrir y cerrar el desplegable de idiomas -->
  <script>
    const dropdown = document.querySelector('.relative');
    const options = document.querySelector('ul');
    dropdown.addEventListener('click', () => {
      options.classList.toggle('hidden');
    });
  </script>