fs        = require('fs')
utils     = require('utils')
#cache    = require('./cache')
#mimetype = require('mimetype')

responses = {}
responses.large = {
  width: 1148
  height: 800
}
responses.medium = {
  width: 768
  height: 1024
}
responses.small = {
  width: 320
  height: 480
}
casper = require('casper').create {
  verbose        : true
  logLevel       : 'debug'
  waitTimeout    : 10000
  stepTimeout    : 10000
  retryTimeout   : 150
  #clientScripts : ["jquery.min.js"]
  viewportSize: responses.large
  pageSettings:
    loadImages         : true
    loadPlugins        : true
    #userAgent          : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv: 22.0) Gecko/20100101 Firefox/22.0'
    # iPhone
    userAgent          : 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_0 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9A334 Safari/7534.48.3'
    webSecurityEnabled : false
    ignoreSslErrors    : true
  onWaitTimeout: () ->
    @echo('wait timeout')
    @clear()
    @page.stop()
  onStepTimeout: (timeout, step) ->
    @echo('step timeout')
    @clear()
    @page.stop()
}

# print out all the messages in the headless browser context
casper.on('remote.message', (msg) ->
  @echo('remote message caught: ' + msg)
)

# print out all the messages in the headless browser context
casper.on('page.error', (msg, trace) ->
   this.echo('Error: ' + msg, 'ERROR')
   for i in trace
     step = trace[i]
     @echo('   ' + step.file + ' (line ' + step.line + ')', 'ERROR')
)


links = [
  "/about/"
  "/menu/drinks/"
  "/menu/wine/"
  "/menu/by-the-glass/"
  "/menu/craft-beer/"
  "/menu/cocktails/"
  "/menu/foods/"
  "/menu/happy-hour/"
  "/menu/small-plates/"
  "/menu/thin-crust-pizzas/"
  "/menu/desserts/"
  "/menu/charcuterie-cheese/"
  "/events/"
  "/gallery/"
  "/blog/"
  "/contact/"

  "/items/the-absolve-meat-cheese-plate/"
  "/items/the-ultimate-charcuterie-cheese-experience/"
  "/items/smoked-duck/"
  "/items/spicy-borsellino/"
  "/items/saucisson-sec/"
  "/items/garrotxa-g/"
  "/items/marieke-gouda-c/"
  "/items/purple-haze/"
  "/items/buttermilk-blue-c/"
  "/items/reading-raclette-c/"
  "/items/ossau-iraty/"
  "/items/zamorano-s/"
  "/items/baby-belletoile-c/"
  "/items/lomo-2/"
  "/items/loukanika-salami/"
  "/items/prosciutto/"
  "/items/chorizo-rioja/"
  "/items/lomo/"
  "/items/purple-haze-g/"
  "/items/ossau-iraty-s/"

  "/items/baaaad-az-pizza/"
  "/items/beefy-caprese/"
  "/items/bruschetta-trio/"
  "/items/but-im-a-fungi/"
  "/items/ceviche/"
  "/items/champagne-donut-bread-pudding/"
  "/items/chilled-avocado-soup/"
  "/items/gimme-the-bill/"
  "/items/herbaceous-hummus/"
  "/items/on-the-vine/"
  "/items/panna-cotta/"
  "/items/smoked-salmon/"
  "/items/the-cheese-factor-dip/"
  "/items/the-pig-and-the-leaf/"
  "/items/the-regular/"
  "/items/the-two-timer/"
  "/items/veggie-tales/"

]

holdLinks = [
  'index.php'
  'menu/craft-beer'
  'menu/by-the-glass'
  'menu/by-the-glass'
  'menu/sparkling'
  'menu/wine'
  'menu/white'
  'menu/red'
  'menu/rose'
  'menu/dessert'
  'menu/champagne'
  'menu/cocktails'
]

holdLinks = [
  "about/"

  "menu/wine/"
  "menu/by-the-glass/"
  "menu/craft-beer/"
  "menu/cocktails/"

  "menu/foods/"
  "menu/happy-hour/"
  "menu/small-plates/"
  "menu/thin-crust-pizzas/"
  "menu/desserts/"
  "menu/charcuterie-cheese/"

  "events/"
  "event/letriel-m-quartet/"
  "event/halloween-with-southern-backtones/"

  "gallery/"

  "blog/"

  "contact/"

  "?s=wine"

]

x = pageName = _pageName = undefined
i = -1
casper.start "http://absolvewinelounge.com/", ->
  # now x is an array of links
  x = links
  return

casper.then ->
  @each x, ->
    ++i
    @thenOpen ("http://absolvewinelounge.com/" + x[i]), ->
      @capture @getTitle().replace(/\|/g, '-') + '.png'
      return
    return
  return

casper.run()

