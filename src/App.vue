<template>
  <!-- Image and text -->
  <nav class="navbar navbar-light bg-light navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        Amused to Death
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>


  <img alt="Vue logo" src="./assets/logo.png">
  <div class="container">
    <AddNewCharacter v-on:save-character="onCharacterSave" />
    <hr class="my-5" />
    <Characters :character-list="characters" />
    <hr class="my-5" />
    <Export :character-list="characters" />
  </div>

</template>

<script>
  import Characters from './components/Characters.vue'
  import AddNewCharacter from './components/AddNewCharacter.vue'
  import Export from './components/Export.vue'

  export default {
    name: 'App',
    components: {
      Characters,
      AddNewCharacter,
      Export
    },
    data() {
      return {
        characters: [],
        links: [],
      }
    },
    methods: {
      onCharacterSave(value) {
        console.log('save was handled')
        this.characters.push(value);
        console.log(this.characters);
      }
    }
  }
</script>

<style>
  #app {
    color: #2c3e50;
  }
</style>