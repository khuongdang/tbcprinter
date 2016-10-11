var slideTime = 2000;
var floatAtBottom = false;

function pepsi_floating_init()
{
	xMoveTo('floating_banner_right', 887 - (800-screen.width), 0);

	winOnResize(); // set initial position
	xAddEventListener(window, 'resize', winOnResize, false);
	xAddEventListener(window, 'scroll', winOnScroll, false);
}
function winOnResize() {
	checkScreenWidth();
	winOnScroll(); // initial slide
}
function winOnScroll() {
  var y = xScrollTop();
  if (floatAtBottom) {
    y += xClientHeight() - xHeight('floating_banner_left');
  }

	if( screen.width <= 800 )
	{
		xSlideTo('floating_banner_left', (screen.width - (800-777) - 772)/2, y+40, slideTime);
  		xSlideTo('floating_banner_right', (screen.width - (800-777) + 772)/2-114, y+40, slideTime);
	}
	else
	{
		xSlideTo('floating_banner_left', (screen.width - (800-777) - 772)/2-114 , y+40, slideTime);
  		xSlideTo('floating_banner_right', (screen.width - (800-777) + 772)/2, y+40, slideTime);
	}
}
function checkScreenWidth()
{
	if( screen.width <= 800 )
	{
		document.getElementById('floating_banner_left').style.display = 'none';
	}

	if(screen.width < 800)
	{
		
		document.getElementById('floating_banner_right').style.display = 'none';
	}
}
