$(function(){
  // console.log('Pagina cargada');

  $('#entriesNumber').change(function(){
    if ( $('tbody tr').length > 0 ){
      $('tbody *').hide(300, function(){
        this.remove();
      });
    }
    if($('.th').length > 0){
      $('.th').hide(500, function(){
        this.remove();
      }); 
      for (let i = 0; i < $('#entriesNumber').val(); i++) {
        $('thead tr').append('<th class="th" style="display:none;"><input class="entrie" name="entries[]" type="text"></th>');
        $('.th').show(1000);
      }
      let p = 100 / $('#entriesNumber').val();
      $('.th').css('width', p+'%');
    } else {
      for (let i = 0; i < $('#entriesNumber').val(); i++) {
        $('thead tr').append('<th class="th" style="display:none;"><input class="entrie" name="entries[]" type="text"></th>');
        $('.th').show(500);
      }
      let p = 100 / $('#entriesNumber').val();
      $('.th').css('width', p + '%');
    }

  });

  $('#statesNumber').change(function(){
    if ($('tbody tr').length > 0) {
      $('tbody tr').hide(300, function () {
        this.remove();
      });
      for (let i = 0; i < $('#statesNumber').val(); i++) {
        let row = '<tr style="display:none;">';
        row += '<td>q'+i+'</td>';
        row += '<td><input class="initial" type="checkbox" name="states[' + i + '][initial]"></td>';
        row += '<td><input class="final" type="checkbox" name="states[' + i + '][final]"></td>';
        for (let j = 0; j < $('#entriesNumber').val(); j++){
          row += '<td><input class="state" name="states['+i+'][]" type="text"></td>';
        }
        row += '</tr>';
        $('tbody').append(row);
        $('tbody tr').show(1200);
      }
    } else {
      for (let i = 0; i < $('#statesNumber').val(); i++) {
        let row = '<tr style="display:none;">';
        row += '<td>q' + i + '</td>';
        row += '<td><input class="initial" type="checkbox" name="states[' + i + '][initial]"></td>';
        row += '<td><input class="final" type="checkbox" name="states['+i+'][final]"></td>';
        for (let j = 0; j < $('#entriesNumber').val(); j++) {
          row += '<td><input class="state" name="states[' + i + '][]" type="text"></td>';
        }
        row += '</tr>';
        $('tbody').append(row);
        $('tbody tr').show(500);
      }
      // let p = 100 / $('#entriesNumber').val();
    }
  });

});