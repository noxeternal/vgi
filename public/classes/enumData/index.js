// eslint-disable-next-line no-unused-vars
class enumData {
  constructor ($http) {
    this.http = $http

    this.categories = []
    this.consoles = []
    this.conditions = []
    this.styles = []
    this.games = []
    this.values = []
    this.extras = []

    this.refresh()
  }

  refresh () {
    return this.http.get('server/enumData.php').then(res => {
    // return this.http.get('https://noxeternal.net/vg/enumData.php').then(res => {
      this.categories = res.data.categories
      this.consoles = res.data.consoles
      this.conditions = res.data.conditions
      this.styles = res.data.styles
      this.games = res.data.games
      this.values = res.data.values
      this.extras = res.data.extras
    })
    .then(() => this.mergeData())
  }

  mergeData () {
    this.games.forEach((g) => {
      if (g.style !== '0') {
        let thisStyle = this.styles.find(s => g.style === s.name)
        g.style = thisStyle.text
      }

      if (g.condition === 'used') {
        if (g.box) { g.icon = 'cube' }
        if (g.manual) { g.icon = 'book' }
      } else {
        if (g.condition === 'digital') { g.icon = 'floppy-o' }
        if (g.condition === 'complete') { g.icon = 'paste' }
        if (g.condition === 'new') { g.icon = 'star' }
      }

      let extras = this.extras.filter(extra => g.id === extra.item)
      g.extras = extras
    })

    return

    this.games.forEach((g) => {
      let thisConsole = this.consoles.find(con => g.console === con.text)
      g.console = {
        'id': thisConsole.id,
        'text': thisConsole.text
      }

      g.category = this.categories.find(cat => g.category === cat.id)
      g.condition = this.conditions.find(cond => g.condition === cond.id)

      let thisValue = this.values.find(value => g.id === value.item)
      if (thisValue) {
        g.value = {
          'id': thisValue.id,
          'amount': thisValue.value
        }
      }
    })
  }
}
