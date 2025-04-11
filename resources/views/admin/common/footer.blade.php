<footer class="footer__area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__left">
                        @if(get_option('iel'))
                        <h2>{{__(get_option(readableValue('YXBwX2NvcHlyaWdodA==')))}}</h2>
                        @else
                            <h2>{{readableValue('wqkgMjAyNCBMTVNaYWkuIEFsbCBSaWdodHMgUmVzZXJ2ZWQ=')}}</h2>
                        @endif
                    </div>
                    <div class="footer__copyright__right">
                        @if(get_option('iel'))
                        <h2>{{__(get_option(readableValue('YXBwX2RldmVsb3BlZA==')))}}</h2>
                        @else
                            <h2>{{readableValue('RGVzaWduICYgRGV2ZWxvcGVkIEJ5')}} <a class="link-primary" target="_blank" href="{{readableValue('aHR0cHM6Ly96YWluaWtsYWIuY29t')}}">{{readableValue('WmFpbmlrbGFi')}}</a></h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
