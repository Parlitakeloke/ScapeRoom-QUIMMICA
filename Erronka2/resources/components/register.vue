<template>
<div class="lg:block hidden overlay-container container bg-green-900 h-screen  " :class="{ 'right-panel-active': isRightPanelActive }" ref="container">

      <div class="overlay ">
          <div class="overlay-panel overlay-right bg-gradient-to-r from-green-800 to-green-400 ">
              <h1>Kaixo!!!</h1>
              <p>Sartu zure datu pertsonalak eta gurekin bidaia hasteko.</p><br>
              <button class="ghost border" id="signUp" @click="signUp">Logeatu</button><br>
            </div>
            <div class="overlay-panel overlay-left bg-gradient-to-r from-green-700 to-green-900 ">
              <h1>Ongi Etorri Berriz!!!</h1>
              <p>Gurekin konektatuta egoteko, mesedez, sartu zure datuak.</p>
              <button class="ghost border" id="signIn" @click="signIn">Erregistratu</button>
            </div>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        isRightPanelActive: false
      };
    },
    methods: {
      signUp() {
        this.isRightPanelActive = true;
      },
      signIn() {
        this.isRightPanelActive = false;
      }
    }
  }
  </script>

  <style scoped>
  /* Your other CSS rules */

  /* LOGIN */
  /* Rest of your CSS styles */
  </style>
