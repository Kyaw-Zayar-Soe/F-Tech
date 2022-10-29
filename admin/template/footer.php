


</div>
</div>
</section>
<script src="./assets/vendor/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./assets/vendor/way_point/jquery.waypoints.js"></script>
<script src="./assets/vendor/counter_up/counter_up.js"></script>
<script src="./assets/vendor/chart_js/chart.min.js"></script>
<script src="./assets/vendor/data_table/jquery.dataTables.min.js"></script>
<script src="./assets/vendor/data_table/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script src="./assets/js/app.js"></script>
<script>
    let currentPage = location.href;
    $(".menu-item-link").each(function () {
        let links = $(this).attr("href");
        console.log(links)
        if(currentPage == links){
            $(this).addClass('active');
        }
        if(currentPage == "http://localhost/projects/F-tech/admin/"){
            $('.menu-item-link').first().addClass('active');
        }
    });

    $('#confirm-delete').on('show.bs.modal', function(e) {
	      $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});
</script>

</body>
</html>