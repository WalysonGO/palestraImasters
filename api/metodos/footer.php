</div>
<script>
    $('.label-origem').on('click', function () {
       $('#origem').val('5541999561066');
    });
    $('.label-destino').on('click', function () {
        $('#destino').val('5541991251142');
    });
    $('.form').on('submit', function () {
        var screenBlock = $('#screenBlock');
        screenBlock.css({width: $(window).width(), height: $(window).height()});
        screenBlock.show();
    });
</script>
</body>
</html>