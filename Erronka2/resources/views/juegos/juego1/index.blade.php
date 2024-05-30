@extends('layout.plantilla2')

@section('title', 'Juego1')

@section('content')


    <body>
        <div class="min-h-screen min-w-screen bg-cover bg-no-repeat bg-center"
            style="background-image: url('../../storage/images/juego1.png');">
            <div class="fade"></div>

        <section class="star-wars">
            <div class="crawl">
                <div class="title">
                    <span class="ml-3 text-8xl font-figtree font-bold z-50 text-white   ">
                        QUIMM<span class="text-lime-400  text-8xl font-figtree">ICA</span>
                    </span>
                </div>

                    <p class="text-white">Jon, Ane, Iker eta Nora lau lagunak dira, eta quimika ikasten duten unibertsitateko
                        ikasleak. Gaurko egunean, laborategian praktika bat egin behar zuten, baina zerbait gaizki joan zen.
                        Likido bat eskapatu zen, eta laborategiko ateak itxi egin ziren. Alarmak hasi ziren soinatzeko, eta
                        bozgorailu bat esan zuen: "Kontuz, kontuz! Quimikoki kutsatutako eremua. Ateak irekitzeko, kodea
                        sartu behar duzue. Baina zerbait gertatzen zen, klasean genuen IA (ChatGPT) maltzurra bihurtu da! Kodea lortzeko, laborategiko pistak jarraitu behar dituzue. Zuek bakarrik atera
                        ahal zarete hemendik. Zorte on!"</p>
                    <br>

                    <p class="text-white">Lau lagunak beldur eta harrituta geratu ziren. Zer egin behar zuten? Nola lortuko
                        zuten kodea? Zer gertatuko zen, likido horrek kaltetu egin zien? Denbora gutxi zuten, eta ez zuten
                        inor deitu ahal. Beraz, erabaki zuten pistak bilatzen hasteko.</p>
                    <br>

                    <p class="text-white">Lehenengo pista, mahai batean zegoen. <b>Kimika elementu hauk lotu bere
                            formularekin
                        </b></p>
                        <p class="text-white">...
                        </b></p>
                </div>
            </section>
            <div id="juego1" class="pt-12" data-id="{{ $id }}" data-route="{{ route('juego1.store') }}">
                <Chemical> </Chemical>
            </div>
        </div>

</body>

    <script>
        window.onload = function() {
            var headers = document.getElementsByTagName('header');
            for (var i = 0; i < headers.length; i++) {
                headers[i].style.display = 'none';
            }

            var footers = document.getElementsByTagName('footer');
            for (var i = 0; i < footers.length; i++) {
                footers[i].style.display = 'none';
            }

            setTimeout(function() {
                var headers = document.getElementsByTagName('header');
                for (var i = 0; i < headers.length; i++) {
                    headers[i].style.display = 'block';
                }

                var footers = document.getElementsByTagName('footer');
                for (var i = 0; i < footers.length; i++) {
                    footers[i].style.display = 'block';
                }

                document.getElementById('juego1').style.display = 'block';
                document.querySelector('.star-wars').style.display = 'none';
                document.querySelector('.fade').style.display = 'none';


            },20000); // 10000 milliseconds = 10 seconds
        };
        window.userId = <?php echo Auth::user()->id; ?>;
    </script>

@endsection
