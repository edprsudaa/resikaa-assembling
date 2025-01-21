<?php
$this->registerJs("
$('.knob').knob({
    'min':0,
    'max':1000,
    'change' : function (v) { console.log(v); },
    format: function (value) {
        return value + 'ms'; 
    },
    draw: function () {

      if (this.$.data('skin') == 'tron') {

        var a   = this.angle(this.cv)  // Angle
          ,
            sa  = this.startAngle          // Previous start angle
          ,
            sat = this.startAngle         // Start angle
          ,
            ea                            // Previous end angle
          ,
            eat = sat + a                 // End angle
          ,
            r   = true

        this.g.lineWidth = this.lineWidth

        this.o.cursor
        && (sat = eat - 0.3)
        && (eat = eat + 0.3)

        if (this.o.displayPrevious) {
          ea = this.startAngle + this.angle(this.value)
          this.o.cursor
          && (sa = ea - 0.3)
          && (ea = ea + 0.3)
          this.g.beginPath()
          this.g.strokeStyle = this.previousColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
          this.g.stroke()
        }

        this.g.beginPath()
        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
        this.g.stroke()

        this.g.lineWidth = 2
        this.g.beginPath()
        this.g.strokeStyle = this.o.fgColor
        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
        this.g.stroke()

        return false
      }
    }
  })



  $('#tes').val(1100).trigger('change');
  

"); ?>
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-chart-bar"></i>
                jQuery Knob Tron Style
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-6 col-md-3 text-center">
                    <div style="display:inline;width:120px;height:120px;"><canvas width="120" height="120"></canvas><input type="text" class="knob" value="60" data-skin="tron" data-thickness="0.2" data-width="120" data-height="120" data-fgcolor="#f56954" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;"></div>
                    <div class="knob-label">data-width="120"</div>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <div style="display:inline;width:120px;height:120px;"><canvas width="120" height="120"></canvas><input type="text" class="knob" value="60" data-skin="tron" data-thickness="0.2" data-width="120" data-height="120" data-fgcolor="#f56954" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;"></div>
                    <div class="knob-label">data-width="120"</div>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <div style="display:inline;width:120px;height:120px;"><canvas width="120" height="120"></canvas><input type="text" class="knob" value="100" data-skin="tron" data-thickness="0.2" data-width="120" data-height="120" data-fgcolor="#f56954" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;"></div>
                    <div class="knob-label">data-width="120"</div>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <div style="display:inline;width:120px;height:120px;"><canvas width="120" height="120"></canvas><input id='tes' type="text" class="knob" value="60" data-skin="tron" data-thickness="0.2" data-width="120" data-height="120" data-fgcolor="#f56954" style="width: 64px; height: 40px; position: absolute; vertical-align: middle; margin-top: 40px; margin-left: -92px; border: 0px; background: none; font: bold 24px Arial; text-align: center; color: rgb(245, 105, 84); padding: 0px; appearance: none;"></div>
                    <div class="knob-label">data-width="120"</div>
                </div>


            </div>

        </div>

    </div>

</div>