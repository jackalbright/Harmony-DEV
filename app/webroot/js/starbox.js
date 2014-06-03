//  Starbox 0.2
//  by Nick Stakenburg - http://www.nickstakenburg.com
//  17-11-2007
//
//  More information on this project:
//  http://www.nickstakenburg.com/projects/starbox/
//
//  Licensed under the Creative Commons Attribution 3.0 License
//  http://creativecommons.org/licenses/by/3.0/
//

var Starboxes = {
  overlayImage: '/images/default.png',
  effectsAvailable: (window.Effect && Effect.Morph),

  REQUIRED_Prototype: '1.6.0',
  REQUIRED_Scriptaculous: '1.8.0',

  start: function() {
    this.require('Prototype');
    var starboxCSS = $A(document.getElementsByTagName("link")).find( function(l) {
      return (l.href && l.href.match(/starbox\.css$/));
    });
    this.imageSource = starboxCSS ? starboxCSS.href.replace(/starbox\.css$/,'') : '';
  },

  require: function(library) {
    if ((typeof window[library] == 'undefined') ||
      (this.convertVersionString(window[library].Version) < this.convertVersionString(this['REQUIRED_' + library])))
      throw('Prototip requires ' + library + ' >= ' + this['REQUIRED_' + library]);
  },

  convertVersionString: function(versionString) {
    var r = versionString.split('.');
    return parseInt(r[0])*100000 + parseInt(r[1])*1000 + parseInt(r[2]);
  },

  fixIE: (function(agent){
    var version = new RegExp('MSIE ([\\d.]+)').exec(agent);
    return version ? (parseFloat(version[1]) <= 6) : false;
  })(navigator.userAgent),

  imagecache: [],
  cacheImage: function(imageInfo){
    if(!this.getCachedImage(imageInfo.src)) this.imagecache.push(imageInfo);
  },

  getCachedImage: function(src) {
    return this.imagecache.find(function(imageInfo) { return imageInfo.src == src });
  }
};
Starboxes.start();

var Starbox = Class.create({
  initialize: function(element, average){
    this.element = $(element),
    this.average = average;
    this.rating = average;
    alert("START");

    this.options = Object.extend({
      background: false,
      buttons: 5,
      className : 'default',
      color: false,
      duration: 0.6,
      effect: { mouseover: false , mouseout: Starboxes.effectsAvailable },
      hoverColor: false,
      hoverClass: 'hover',
      identity: false,      
      indicator: false,
      inverse: false,
      locked: false,
      lockOnRate: true,
      max: 5,
      onRate: false,
      overlay: Starboxes.overlayImage,
      stars: 5,
      total : 0
    }, arguments[2] || {});

    if (this.options.effect && (this.options.effect.mouseover || this.options.effect.mouseout))
	  Starboxes.require('Scriptaculous');

    this.buildWrapper();
    if (this.options.effect) this.scope = this.wrapper.identify();
  },

  enable: function() {
    this.mouseOverEvent = this.onMouseOver.bindAsEventListener(this);
    this.mouseOutEvent = this.onMouseOut.bindAsEventListener(this);
    this.clickEvent = this.onClick.bindAsEventListener(this);

    this.element.observe('mouseover', this.mouseOverEvent);
    this.element.observe('mouseout', this.mouseOutEvent);
    this.element.observe('click', this.clickEvent);
  },

  disable: function() {
    this.element.stopObserving('mouseover', this.mouseOverEvent);
    this.element.stopObserving('mouseout', this.mouseOutEvent);
    this.element.stopObserving('click', this.clickEvent);
  },

  buildWrapper: function() {
    this.element.addClassName('starbox');
	
	// wrapper
    this.wrapper = new Element('div', { 'class': this.options.className + ' stars' });
    if (this.options.background) this.wrapper.setStyle({ background: this.options.background });

    // hover 
    this.hover = this.wrapper.appendChild(new Element('div'));
    this.hover.setStyle({ background: this.options.hoverColor || 'none' });

    // stars
    this.imageInfo = Starboxes.getCachedImage(this.options.overlay);
    if(!this.imageInfo) {
      var starImage = new Image();
      starImage.onload=function() {
        this.imageInfo = {
          src: this.options.overlay,
          height: starImage.height,
          width: starImage.width,
          fullsrc: starImage.src
        };
        Starboxes.cacheImage(this.imageInfo);
        this.build();
      }.bind(this);
      starImage.src = Starboxes.imageSource + this.options.overlay;
    }
    else this.build();
  },

  build: function() {
    this.starWidth = this.imageInfo.width;
    this.starHeight = this.imageInfo.height;
    this.starSrc = this.imageInfo.fullsrc;
    this.boxWidth = this.starWidth * this.options.stars;
    this.buttonWidth = this.boxWidth / this.options.buttons;
    this.buttonRating = this.options.max / this.options.buttons;

    if(this.options.effect) {
      this.zeroPosition = this.getColorbarPosition(0);
      this.maxPosition = this.getColorbarPosition(this.options.max);
    }

    var baseStyle = { width: this.boxWidth + 'px', height: this.starHeight + 'px' };
    var starStyle = { position: 'absolute', top: 0, left: 0, width: this.starWidth + 'px', height: this.starHeight + 'px' };
    var wrapperStyle = Object.extend({ position: 'relative', overflow: 'hidden' }, baseStyle);
    var layerStyle = Object.extend({ position : 'absolute', top: 0, left: 0 }, baseStyle);

    this.wrapper.setStyle(wrapperStyle);
    this.colorbar = this.hover.appendChild(new Element('div', { 'class': 'colorbar'}).setStyle(layerStyle));
    if (this.options.color) this.colorbar.setStyle({ background: this.options.color });

    var starWrapper = this.hover.appendChild(new Element('div').setStyle(layerStyle));
    this.starbar = starWrapper.appendChild(new Element('div').setStyle(wrapperStyle));

    this.options.stars.times(function(i){
      var star = this.starbar.appendChild(new Element('div').setStyle(Object.extend({
        background: 'url(' + this.starSrc + ') top left no-repeat'
      }, starStyle)));
      star.setStyle({ left: this.starWidth * i + 'px' });

	  if (Starboxes.fixIE) {
        star.setStyle({	
          background: 'none', 'filter' : 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'' + 
          this.starSrc + '\'\', sizingMethod=\'scale\')'
        });
      }
    }.bind(this));

    this.buttons = [];
    this.options.buttons.times(function(i){
      var leftPos = this.options.inverse ? this.boxWidth - this.buttonWidth * (i + 1) : this.buttonWidth * i;
      var button = this.starbar.appendChild(new Element('div', { href: 'javascript:;' }).setStyle({
        position: 'absolute', 
        top: 0, 
        left: leftPos + 'px',
        width: this.buttonWidth + (Starboxes.fixIE ? 1 : 0) + 'px',
        height: this.starHeight + 'px',
        cursor: this.options.locked ? 'auto' : 'pointer'
      }));
      button.rating = this.buttonRating + (this.buttonRating * i);
	  this.buttons.push(button);
    }.bind(this));

    this.setRating(this.average, false);
    this.element.update(this.wrapper);

    if (this.options.indicator) {
      this.indicator = this.element.appendChild(new Element('div', { 'class' : 'indicator' }));
      this.updateIndicator();
    }

    if (!this.options.locked) this.enable();
  },

  updateAverage: function(increment) {
    this.options.total++;
    this.average = (this.average == 0) ? increment :
      ((this.average * (this.options.total-1) + increment) / this.options.total);
  },

  updateIndicator: function() {
    this.indicator.update(new Template(this.options.indicator).evaluate({
      max: this.options.max,
      total: this.options.total,
      average: (this.average * 10).round() / 10
    }));
  },

  getColorbarPosition : function(rating) {
    var position = (this.boxWidth - (rating/this.buttonRating) * this.buttonWidth);
    position = this.options.inverse ? position.ceil() : -1 * position.floor();
    return parseInt(position);
  },

  setRating: function(rating){
    if (this.options.effect && this.activeEffect) Effect.Queues.get(this.scope).remove(this.activeEffect);
    var left = this.getColorbarPosition(rating);

    if (arguments[1]) {
      current = parseInt(this.colorbar.getStyle('left'));
      to = this.getColorbarPosition(rating);
      if (current == to) return;
        var mspeed = ((this.maxPosition - (current - to).abs()).abs() / this.zeroPosition.abs()).toFixed(2);

      this.activeEffect = new Effect.Morph($(this.colorbar), { style: { left: left + 'px' },
        queue: { position: 'end', limit: 1, scope: this.scope}, duration: (this.options.duration * mspeed),
          afterFinish: function() { this.rating = rating }.bind(this) });
    }
    else {
      this.rating = rating;
      this.colorbar.setStyle({ left: left + 'px' });
    }
  },

  onClick: function(event) {
    var element = Event.element(event);
    if (!element.rating || !this.options.onRate) return;

    this.updateAverage(element.rating);
    if (this.options.indicator) this.updateIndicator();

    if (this.options.lockOnRate) {
      this.disable();
      this.buttons.invoke('setStyle', { cursor: 'auto' });
	}

    var info = {
      identity: this.identity,
      rating: element.rating,
      average: this.average,
      max: this.options.max,
      total: this.options.total
    };
    this.options.onRate(this.element, info);
  },

  onMouseOut: function(event) {
    this.setRating(this.average, (this.options.effect && this.options.effect.mouseout));

    this.hovered = false;
    if (this.options.hoverClass) this.hover.removeClassName(this.options.hoverClass);
    if (this.options.hoverColor) this.colorbar.setStyle({ background: this.options.color });
  },

  onMouseOver: function(event) {
    var element = Event.element(event);
    if (!element.rating) return;

    this.setRating(element.rating, (this.options.effect && this.options.effect.mouseover ? true : false));
    if(!this.hovered && this.options.hoverClass) this.hover.addClassName(this.options.hoverClass);
    this.hovered = true;
    if (this.options.hoverColor) this.colorbar.setStyle({ background: this.options.hoverColor });
  }
});
