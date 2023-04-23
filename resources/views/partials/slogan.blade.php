<div class="w-[1440px] h-[696px] flex justify-center sm:w-max">
    {{-- SLOGAN SECTION --}}
    <div class="lg:w-1/2 text-center pt-16 pl-32">
        <div class="font-black text-5xl text-left mr-16">
            <p>
                Gana y valida experiencia como programador
            </p>
        </div>

        <div>
            <div class="lg:invisible ">
                <div class="flex items-center justify-center">
                    <img class="h-[43px]" src="{{ asset('img/angular.png') }}" alt="Angular Logo">
                    <img class="h-[59px]" src="{{ asset('img/react.png') }}" alt="React Logo">
                    <img class="h-[54px]" src="{{ asset('img/nodejs.png') }}" alt="Nodejs Logo">
                    <img class="h-[38px]" src="{{ asset('img/python.png') }}" alt="Python Logo">
                    <img class="h-[58px]" src="{{ asset('img/php.png') }}" alt="PHP Logo">
                </div>
                <div class="flex items-center justify-center">
                    <img class="h-[52px] " src="{{ asset('img/java.png') }}" alt="Java Logo">
                    <img class="h-[50px] " src="{{ asset('img/git.png') }}" alt="Git Logo">
                    <img class="h-[41px] " src="{{ asset('img/scrum.png') }}" alt="Scrum Logo">
                </div>
            </div>
        </div>

        <div class="mt-16">
            <div class="flex items-center">
                <img class="absolute mr-[18px]" src="{{ asset('img/Ellipse.png') }}" alt="">
                <img class="absolute  ml-2 mr-[18px]" src="{{ asset('img/Vector.png') }}" alt="">
                <div class="ml-8 font-black">
                    <p>
                        ¿Cómo colaborar?
                    </p>
                </div>
            </div>
            <div class="mt-7">
                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-96 border-b border-gray-900"></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 w-96 text-left">
                <p>
                    La falta de experiencia te dificulta conseguir trabajo? Trabaja en equipo y ponte a prueba con nuestros proyectos
                </p>
            </div>
        </div>
        <div class="lg:invisible">
            <img src="{{ asset('img/itacademylogo.png') }}" alt="IT Academy Logo">
        </div>
    </div>

    {{-- LOGOS SECTION --}}
    <div id="logos-section" class="lg:w-1/2 w-0 lg:visible invisible">
        <img class="repel absolute mt-[34px] mr-[495px] ml-[108px]" src="{{ asset('img/angular.png') }}" alt="Angular Logo">
        <img class="repel absolute mt-[7px] mr-[118px] ml-[432px]" src="{{ asset('img/php.png') }}" alt="PHP Logo">
        <img class="repel absolute mt-[88px] mr-[225px] ml-[198px]" src="{{ asset('img/react.png') }}" alt="React Logo">
        <img class="repel absolute mt-[232px] mr-[591px] ml-[-12px]" src="{{ asset('img/java.png') }}" alt="Java Logo">
        <img class="repel absolute mt-[249px] mr-[396px] ml-[166px]" src="{{ asset('img/nodejs.png') }}" alt="Nodejs Logo">
        <img class="repel absolute mt-[228px] mr-[152px] ml-[465px]" src="{{ asset('img/python.png') }}" alt="Python Logo">
        <img class="repel absolute mt-[429px] mr-[418px] ml-[159px]" src="{{ asset('img/git.png') }}" alt="Git Logo">
        <img class="repel absolute mt-[385px] mr-[216px] ml-[384px]" src="{{ asset('img/scrum.png') }}" alt="Scrum Logo">
        <img class="absolute mt-[601px] mr-[32px] ml-[524px] mb-[54px]" src="{{ asset('img/itacademylogo.png') }}" alt="IT Academy Logo">
    </div>
    {{-- Repel effect in logos section --}}
    <script>
        function handleMouseMove(event) {
            const images = document.querySelectorAll('.repel');
            const threshold = 100;

            images.forEach(image => {
                const rect = image.getBoundingClientRect();
                const centerX = rect.left + (rect.width / 2);
                const centerY = rect.top + (rect.height / 2);
                const distance = Math.sqrt(Math.pow(centerX - event.clientX, 2) + Math.pow(centerY - event.clientY, 2));

                if (distance < threshold) {
                    const dx = centerX - event.clientX;
                    const dy = centerY - event.clientY;
                    const angle = Math.atan2(dy, dx);
                    const force = ((threshold - distance) / threshold) * 100;
                    const x = force * Math.cos(angle);
                    const y = force * Math.sin(angle);
                    image.style.transform = `translate(${x}px, ${y}px)`;
                } else {
                    image.style.transform = 'translate(0, 0)';
                }
            });
        }
        document.addEventListener('mousemove', handleMouseMove);
    </script>

</div>