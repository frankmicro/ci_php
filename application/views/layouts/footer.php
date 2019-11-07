	<footer> 
        <p class="text-center">&copy; 2015 CI Auth</p>                  
    </footer>

 	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/jquery.min.js"><\/script>')</script>
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script>

    <script type="text/javascript">
        var table;
    	$(document).ready(function() {
         var table = $('#example').DataTable({
                "order":[],
                "processing": true,
                "serverSide": true,
                "pageLength": 10,
                'aoColumnDefs': [{
                   'bSortable': false,
                   'aTargets': ['nosort']
               }],
                "searching": true,
                "ordering": true,
                 "language": {
                        "paginate": {
                            "next": '»',
                            "previous": '«'
                        },
                        "zeroRecords": "No Records Found"
                    },
                 "ajax":{
                             "url": '<?php base_url(); ?>admin/getdata',
                             "type": "POST",
                             "dataType": "json"
                           },
                "columns" : [
                    {'data':'id'},
                    {'data':'username'},
                    {'data':'role'},
                    {'data':'status'}
                    ]

            });

            $('.search-input-select').on( 'change', function () {   // for select box
            var i =$(this).attr('data-column');
            var v =$(this).val();
            table.columns(i).search(v).draw();

            });

            $('.search-input-text').on( 'keyup', function () {   // for text boxes
                var i =$(this).attr('data-column');  // getting column index
                var v =$(this).val();  // getting search input value
                table.columns(i).search(v).draw();
             });

    });
    </script>

  </body>
</html>
