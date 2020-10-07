<template>
  <!-- Image and text -->
  <nav class="navbar navbar-light bg-light navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"> Amused to Death </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" v-for="link in links" :key="link.id">
            <a
              class="nav-link"
              :class="link.disabled ? 'disabled' : ''"
              aria-current="page"
              :href="link.href"
              :aria-disabled="link.disabled"
              :target="link.target"
              >{{ link.name }}</a
            >
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <img alt="A2D logo" src="./assets/a2d.png" class="d-block mx-auto mb-5" />
  <div class="container">
    <AddNewCharacter
      v-on:save-character="onCharacterSave"
      :character-to-update="characterToUpdate"
    />
    <hr class="my-5" />
    <Characters
      :character-list="characters"
      v-on:update-character="onCharacterUpdate"
      v-on:remove-character="onCharacterRemove"
      v-on:toggle-saved="onToggleSaved"
    />
    <hr class="my-5" />
    <Export :character-list="characters" />
  </div>
</template>

<script>
import Characters from "./components/Characters.vue";
import AddNewCharacter from "./components/AddNewCharacter.vue";
import Export from "./components/Export.vue";

export default {
  name: "App",
  components: {
    Characters,
    AddNewCharacter,
    Export,
  },
  data() {
    return {
      characters: [],
      characterToUpdate: {
        id: Math.floor(Math.random() * 133769),
        name: "",
        server: "",
        className: 0,
        ilvl: 0,
        tank: false,
        healer: false,
        dps: false,
        saved: false,
      },
      links: [
        {
          id: 1,
          name: "Source-code",
          href:
            "https://github.com/kristoffer-tvera/website-sylvanas-raid-signup",
          disabled: false,
          target: "_blank",
        },
        {
          id: 2,
          name: "Issues",
          href:
            "https://github.com/kristoffer-tvera/website-sylvanas-raid-signup/issues",
          disabled: false,
          target: "_blank",
        },
        {
          id: 3,
          name: "Donate",
          href: "https://www.savethechildren.org/",
          disabled: false,
          target: "_blank",
        },
        {
          id: 4,
          name: "BNet Import ",
          href: "https://signup.amusedtodeath.eu/bnet/",
          disabled: false,
          target: "_self",
        }
      ],
    };
  },
  beforeMount() {
    let fromLocalStorage = localStorage.getItem("characters");
    if (fromLocalStorage) {
      var characterList = JSON.parse(fromLocalStorage);
      this.characters = characterList;
    }
  },
  methods: {
    onCharacterSave(char) {
      let index = -1;
      for (let i = 0; i < this.characters.length; i++) {
        if (this.characters[i].id == char.id) index = i;
      }

      if (index === -1) {
        this.characters.push(char);
      } else {
        this.characters[index] = char;
      }

      localStorage.setItem("characters", JSON.stringify(this.characters));
    },
    onCharacterUpdate(id) {
      console.log("starting update: " + id);
      let character = this.characters.find((el) => el.id === id);
      if (character) {
        console.log("updating: " + character.id);
        this.characterToUpdate = character;
      }
      let myCollapser = document.querySelector(
        'button.collapsed[data-target="#update-character"]'
      );
      if (myCollapser) {
        myCollapser.click();
      }
    },
    onCharacterRemove(id) {
      for (let i = 0; i < this.characters.length; i++) {
        if (this.characters[i].id === id) {
          this.characters.splice(i, 1);
        }
      }
    },
    onToggleSaved(id) {
      for (let i = 0; i < this.characters.length; i++) {
        if (this.characters[i].id === id) {
          this.characters[i].saved = !this.characters[i].saved;
        }
      }
    },
  },
};
</script>

<style>
#app {
  color: #2c3e50;
}
</style>