<template>
    <div class="row">
        <div class="col-12">
            <p style="color: black;">
                <span class="h5">Intentos: </span>
                {{ intentos }}/{{ MAXIMOS_INTENTOS }}&nbsp;<span class="h5">Aciertos:
                </span> {{ aciertos }}
            </p>
        </div>
    </div>
    <div v-for="(fila, indiceFila) in memorama" :key="indiceFila" class="row">
        <div :key="indiceFila + '' + indiceImagen" class="col-3" v-for="(imagen, indiceImagen) in fila">
            <div class="mb-4 offset-3">
                <img @click="voltear(indiceFila, indiceImagen)" :class="{ 'girar': imagen.mostrar }" :src="(imagen.mostrar ? imagen.ruta :
                    NOMBRE_IMAGEN_OCULTA)" class="card-img-top img-fluid
                img-thumbnail">
            </div>
        </div>
    </div>
    <p id="bot"></p>
</template>
<script>
import Swal from 'sweetalert2'

const MAXIMOS_INTENTOS = 8, // Intentos máximos que tiene el jugador
    COLUMNAS = 4, // Columnas del memorama
    SEGUNDOS_ESPERA_VOLTEAR_IMAGEN = 1, // Por cuántos segundos mostrar ambas imágenes
    NOMBRE_IMAGEN_OCULTA =                 "../../storage/app/public/images/juego4/pizarra_juego4.png";// La imagen que se muestra cuando la real está oculta


export default {
    data() {
        return {
            // La ruta de las imágenes. Puede ser relativa o absoluta
            game: true,
            win: false,
            lost: false,
            imagenes: [
                "../../storage/app/public/images/juego4/pizarra_juego4.png",
                "../../storage/app/public/images/juego4/armario.png",
                "../../storage/app/public/images/juego4/abierta.png",
                ".../../storage/app/public/images/juego4/pizarra_juego4.png",
                "../../storage/app/public/images/juego4/armario.png",
                "../../storage/app/public/images/juego4/pizarra_juego4.png",

            ],
            memorama: [],
            // Útiles para saber cuál fue la carta anteriormente seleccionada
            ultimasCoordenadas: {
                indiceFila: null,
                indiceImagen: null,
            },
            NOMBRE_IMAGEN_OCULTA: NOMBRE_IMAGEN_OCULTA,
            MAXIMOS_INTENTOS: MAXIMOS_INTENTOS,
            intentos: 0,
            aciertos: 0,
            esperandoTimeout: false,
        }
    },
    methods: {
        // Método que indica si el jugador ha ganado
        haGanado() {
            return this.memorama.every(arreglo => arreglo.every(imagen => imagen.acertada));
        },

        // Ayudante para mezclar un arreglo
        mezclarArreglo(a) {
            var j, x, i;
            for (i = a.length - 1; i > 0; i--) {
                j = Math.floor(Math.random() * (i + 1));
                x = a[i];
                a[i] = a[j];
                a[j] = x;
            }
            return a;
        },
        // Aumenta un intento y verifica si el jugador ha perdido
        // aumentarIntento() {

        // },
        // Se desencadena cuando se hace click en la imagen
        voltear(indiceFila, indiceImagen) {
            if (this.game) {

                // Si se está regresando una imagen a su estado original, detener flujo
                if (this.esperandoTimeout) {
                    return;
                }
                // Si es una imagen acertada, no nos importa que la intenten voltear
                if (this.memorama[indiceFila][indiceImagen].acertada) {
                    return;
                }
                // Si es la primera vez que la selecciona
                if (this.ultimasCoordenadas.indiceFila === null && this.ultimasCoordenadas.indiceImagen === null) {
                    this.memorama[indiceFila][indiceImagen].mostrar = true;
                    this.ultimasCoordenadas.indiceFila = indiceFila;
                    this.ultimasCoordenadas.indiceImagen = indiceImagen;
                    return;
                }
                // Si es el que estaba mostrada, lo ocultamos de nuevo
                let imagenSeleccionada = this.memorama[indiceFila][indiceImagen];
                let ultimaImagenSeleccionada = this.memorama[this.ultimasCoordenadas.indiceFila][this.ultimasCoordenadas.indiceImagen];
                if (indiceFila === this.ultimasCoordenadas.indiceFila &&
                    indiceImagen === this.ultimasCoordenadas.indiceImagen) {
                    this.memorama[indiceFila][indiceImagen].mostrar = false;
                    this.ultimasCoordenadas.indiceFila = null;
                    this.ultimasCoordenadas.indiceImagen = null;
                    this.intentos++;
                    if (this.intentos >= MAXIMOS_INTENTOS) {
                        this.lost = true
                        this.game = false
                        var pp = document.getElementById("bot");
                        var div1 = document.createElement("div");
                        div1.setAttribute("style", "background-color:grey;border:4px solid green; text-align:center;");

                        var text = document.createElement("h1");
                        text.textContent = "Perdiste";

                        var a = document.createElement("a");
                        a.setAttribute("href", "/menuPrincipal");

                        var boton = document.createElement("button");
                        boton.textContent = "Volver";

                        pp.appendChild(div1);
                        div1.appendChild(text);
                        div1.appendChild(a);
                        a.appendChild(boton);
                    }
                    return;
                }

                // En caso de que la haya encontrado, ¡acierta!
                // Se basta en ultimaImagenSeleccionada
                this.memorama[indiceFila][indiceImagen].mostrar = true;
                if (imagenSeleccionada.ruta === ultimaImagenSeleccionada.ruta) {
                    this.aciertos++;
                    this.memorama[indiceFila][indiceImagen].acertada = true;
                    this.memorama[this.ultimasCoordenadas.indiceFila][this.ultimasCoordenadas.indiceImagen].acertada = true;
                    this.ultimasCoordenadas.indiceFila = null;
                    this.ultimasCoordenadas.indiceImagen = null;
                    // Cada que acierta comprobamos si ha ganado
                    if (this.haGanado()) {
                        this.win = true
                        this.game = false
                        var pp = document.getElementById("bot");
                        var div1 = document.createElement("div");
                        div1.setAttribute("style", "background-color:grey;border:4px solid green; text-align:center;");

                        var text = document.createElement("h1");
                        text.textContent = "Ganaste";

                        var a = document.createElement("a");
                        a.setAttribute("href", "/juego3");

                        var boton = document.createElement("button");
                        boton.textContent = "Continuar";

                        pp.appendChild(div1);
                        div1.appendChild(text);
                        div1.appendChild(a);
                        a.appendChild(boton);
                    }
                } else {
                    // Si no acierta, entonces giramos ambas imágenes
                    this.esperandoTimeout = true;
                    setTimeout(() => {
                        this.memorama[indiceFila][indiceImagen].mostrar = false;
                        this.memorama[indiceFila][indiceImagen].animacion = false;
                        this.memorama[this.ultimasCoordenadas.indiceFila][this.ultimasCoordenadas.indiceImagen].mostrar = false;
                        this.ultimasCoordenadas.indiceFila = null;
                        this.ultimasCoordenadas.indiceImagen = null;
                        this.esperandoTimeout = false;
                    }, SEGUNDOS_ESPERA_VOLTEAR_IMAGEN * 1000);
                    this.intentos++;
                    if (this.intentos >= MAXIMOS_INTENTOS) {
                        this.lost = true
                        this.game = false
                        var pp = document.getElementById("bot");
                        var div1 = document.createElement("div");
                        div1.setAttribute("style", "background-color:grey;border:4px solid green; text-align:center;");
                        var text = document.createElement("h1");
                        text.textContent = "Perdiste";
                        var a = document.createElement("a");
                        a.setAttribute("href", "/menuPrincipal");
                        var boton = document.createElement("button");
                        boton.textContent = "Volver";

                        pp.appendChild(div1);
                        div1.appendChild(text);
                        div1.appendChild(a);
                        a.appendChild(boton);
                    }
                }
            }
        },
        reiniciarJuego() {
            let memorama = [];
            this.imagenes.forEach((imagen, indice) => {
                let imagenDeMemorama = {
                    ruta: imagen,
                    mostrar: false, // No se muestra la original
                    acertada: false, // No es acertada al inicio
                };
                // Poner dos veces la misma imagen
                memorama.push(imagenDeMemorama, Object.assign({}, imagenDeMemorama));
            });

            // Sacudir o mover arreglo; es decir, hacerlo aleatorio
            this.mezclarArreglo(memorama);

            // Dividirlo en subarreglos o columnas
            let memoramaDividido = [];
            for (let i = 0; i < memorama.length; i += COLUMNAS) {
                memoramaDividido.push(memorama.slice(i, i + COLUMNAS));
            }
            // Reiniciar intentos
            this.intentos = 0;
            this.aciertos = 0;
            // Asignar a instancia de Vue para que lo dibuje
            this.memorama = memoramaDividido;
        },
        // Método que precarga las imágenes para que las mismas ya estén cargadas
        // cuando el usuario gire la tarjeta
        precargarImagenes() {
            // Mostrar la alerta
            Swal.fire({
                title: "Cargando",
                html: `Cargando imágenes...`,
                allowOutsideClick: false,
                allowEscapeKey: false,
            })
                .then(this.reiniciarJuego)
            // Ponerla en modo carga
            Swal.showLoading();


            let total = this.imagenes.length,
                contador = 0;
            let imagenesPrecarga = Array.from(this.imagenes);
            // También vamos a precargar la "espalda" de la tarjeta
            imagenesPrecarga.push(NOMBRE_IMAGEN_OCULTA);
            // Cargamos cada imagen y en el evento load aumentamos el contador
            imagenesPrecarga.forEach(ruta => {
                const imagen = document.createElement("img");
                imagen.src = ruta;
                imagen.addEventListener("load", () => {
                    contador++;
                    if (contador >= total) {
                        // Si el contador >= total entonces se ha terminado la carga de todas
                        this.reiniciarJuego();
                        Swal.close();
                    }
                });
                // Agregamos la imagen y la removemos instantáneamente, así no se muestra
                // pero sí se carga
                document.body.appendChild(imagen);
                document.body.removeChild(imagen);
            });
        },
    },
    mounted() {
        this.precargarImagenes();
    },
};
</script>
