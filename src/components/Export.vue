<template>

  <div class="mb-3">
    <button class="btn btn-primary mb-3" type="button" @click="copyText">Copy text</button>
    <label for="export-area" class="form-label sr-only">Example textarea</label>
    <textarea class="form-control" id="export" :rows="rows" readonly="readonly" v-model="textarea"></textarea>
    <button class="btn btn-primary mt-3" type="button" @click="copyText">Copy text</button>

  </div>


</template>

<script>
  export default {
    name: 'Export',
    props: ['characterList'],
    data() {
      return {
        characters: this.characterList,
        rows: 10,
        vertical: false,
      }
    },
    computed: {
      textarea() {
        if (this.vertical) {
          let value = '';
          value += '```';

          value += '\nRole :';
          value += '\nClass:';
          value += '\nilvl :';
          value += '\nLogs :';
          value += '\nSaved:';

          value += '\n```';
          value += '\n(n): https://www.warcraftlogs.com/character/eu/draenor/jsl';


          return value;
        }

        let value = '';
        value += '```';

        let roles = ['Role'];
        let ilvls = ['Ilvl'];
        let classes = ['Class'];
        let logs = ['Logs'];
        let saved = ['Saved'];

        let index = 1;
        this.characters.forEach(char => {
          let charRoles = [];
          if (char.tank) charRoles.push('Tank');
          if (char.healer) charRoles.push('Heal');
          if (char.dps) charRoles.push('Dps');

          let role = charRoles.join('/');

          roles.push(role);
          ilvls.push(char.ilvl);
          classes.push(char.className);
          logs.push('(' + index++ + ')');
          saved.push(char.saved);
        });

        for (let i = 0; i < index; i++) {
          value += '\n';
          value += roles[i] + '|';
          value += ilvls[i] + '|';
          value += classes[i] + '|';
          value += logs[i] + '|';
          value += saved[i];
        }

        value += '\n```';
        for (let i = 0; i < this.characters.length; i++) {
          const char = this.characters[i];
          
        value += '\n(' + (i + 1) + '): https://www.warcraftlogs.com/character/eu/' + char.server + '/' +  char.name;
        }


        return value;
      }
    },
    methods: {
      copyText() {
        let textArea = document.querySelector('#export');
        console.log('TEST');
        if (textArea) {
          try {
            textArea.select();
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            alert('Testing code was copied ' + msg);
          } catch (err) {
            alert('Oops, unable to copy');
          }
        }
      }
    }
  }
</script>

<style scoped>
  textarea {
    font-family: "Courier New", Courier, monospace;

  }
</style>