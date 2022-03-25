<template>
  <div
    tabindex="0"
    @keydown.up.prevent.stop="move(-1)"
    @keydown.down.prevent.stop="move(1)"
    @keydown.esc.prevent.stop="selected.index = null"
    @keydown.33.prevent.stop="moveLeft"
    @keydown.left.prevent.stop="moveLeft"
    @keydown.34.prevent.stop="moveRight"
    @keydown.right.prevent.stop="moveRight"
    @keydown.36.prevent.stop="moveStart"
    @keydown.35.prevent.stop="moveEnd"
    @keydown.enter.prevent.stop="enter"
  >
    <div class="ListadoAcciones">
      <slot name="actions" :selected="{ index: selected.index, item: itemsPage[selected.index] }"></slot>
      <v-pagination v-model="page" small :length="lastPage" :total-visible="7" />
    </div>

    <table ref="table">
      <thead ref="head">
        <slot name="header"></slot>
      </thead>
      <tbody ref="body">
        <tr
          v-for="(item, index) in itemsPage"
          :id="tag + index"
          :key="index"
          :class="selected.index === index ? 'bg-info' : 'null'"
          @click.prevent.stop="clickRow(index)"
        >
          <slot name="body" :item="item"></slot>
        </tr>
      </tbody>
      <tfoot>
        <slot name="footer"></slot>
      </tfoot>
    </table>

    <v-pagination v-model="page" small class="d-none" :length="lastPage" :total-visible="7" />
  </div>
</template>

<script>
  export default {
    name    : 'ProyTable',
    props   : {
      items     : {
        type   : Array,
        default: function () {
          return []
        }
      },
      tag       : {
        type   : String,
        default: 'row'
      },
      pageLength: {
        type   : Number,
        default: 10
      }
    },
    data() {
      return {
        page    : 1,
        selected: {
          index        : null,
          headHeight   : 0,
          clickPosition: 0,
          lastRowHeigth: 0
        },
        click   : undefined
      }
    },
    computed: {
      itemsPage: function () {
        let response = []
        if (this.page > this.lastPage) {
          this.page = 1
        }
        for (let i = (this.page - 1) * this.pageLength; i < this.page * this.pageLength && i < this.items.length; i++) {
          response.push(this.items[i])
        }
        return response
      },
      lastPage : function () {
        return Math.ceil(this.items.length / this.pageLength)
      },
      status   : function () {
        let status = {
          index: this.selected.index,
          item : {}
        }
        if (this.selected.index !== null && this.itemsPage[this.selected.index] !== undefined) {
          status.item = this.itemsPage[this.selected.index]
        }
        return status
      }
    },
    methods : {
      move(a) {
        let newIndex = 0
        if (this.selected.index !== null) {
          newIndex = this.selected.index + a
          if (newIndex < 0) {
            newIndex = this.moveLeft() ? this.pageLength - 1 : 0
          }
          if (newIndex >= this.pageLength || newIndex >= this.itemsPage.length) {
            newIndex = this.moveRight() ? 0 : Math.min(this.pageLength, this.itemsPage.length) - 1
          }
        } else {
          if (a < 0) {
            newIndex = this.pageLength - 1
          } else {
            newIndex = 0
          }
        }
        this.selected.index = newIndex
        this.slide()
      },
      moveRight() {
        if (this.page < this.lastPage) {
          this.page += 1
          this.selected.index = null
          return true
        } else {
          return false
        }
      },
      moveLeft() {
        if (this.page > 1) {
          this.page -= 1
          this.selected.index = null
          return true
        } else {
          return false
        }
      },
      moveStart() {
        this.selected.index = 0
        this.slide()
      },
      moveEnd() {
        this.selected.index = Math.min(this.pageLength, this.itemsPage.length) - 1
        this.slide()
      },
      enter() {
        this.$emit('enter', this.status)
      },
      slide() {
        let row                   = this.$refs.body.querySelector('#' + this.tag + this.selected.index)
        let newPosition           = row.offsetTop - this.selected.headHeight - this.selected.clickPosition
        this.$refs.body.scrollTop = newPosition
        if (this.$refs.body.scrollTop !== newPosition) {
          this.selected.clickPosition = row.offsetTop - this.selected.headHeight - this.$refs.body.scrollTop
        }
      },
      clickRow(index) {
        if (this.click !== undefined) {
          this.selectRow(index)
          this.$emit('enter', this.status)
          clearTimeout(this.click)
        } else {
          this.click = setTimeout(() => {
            this.click = undefined
          }, 500)
          if (index !== this.selected.index) {
            this.selectRow(index)
          } else {
            this.selected.index = null
          }
        }
      },
      selectRow(index) {
        this.selected.index         = index
        let row                     = this.$refs.body.querySelector('#' + this.tag + index)
        this.selected.headHeight    = this.$refs.head.offsetHeight
        this.selected.clickPosition = row.offsetTop - this.selected.headHeight - this.$refs.body.scrollTop
        this.selected.lastRowHeigth = row.offsetHeight
      }
    }
  }
</script>

<style scoped>
</style>
