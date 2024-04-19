function toggleComment(button) {
  var card = button.closest('.card'); // Mendapatkan parent card
  var commentBox = card.querySelector('.comment-box'); // Mengambil elemen comment-box dalam parent card
  commentBox.style.display = (commentBox.style.display === 'none' || commentBox.style.display === '') ? 'block' : 'none';
}



// Fungsi untuk menangani peningkatan jumlah like atau menghapus like
function toggleLike(button) {
  var postId = $(button).closest('.card').data('post-id');
  var likeCount = $(button).find('.like-count');
  var likeIcon = $(button).find('.fa-heart');
  

  // Pastikan postId dan userId tidak kosong
  if (!postId) {
      console.error('postId tidak valid.');
      return;
  }
  
  // Dapatkan token CSRF dari meta tag
  var csrfToken = $('meta[name="csrf-token"]').attr('content');

  // Periksa status like untuk post ini
  $.ajax({
      method: 'GET',
      url: '/like-status',
      data: { 
          postId: postId,
          _token: csrfToken
      },
      success: function(response) {
          if (response.liked) {
              // Jika pengguna telah melakukan like, hapus like
              unlikePost(postId, csrfToken, likeCount, likeIcon);
          } else {
              // Jika pengguna belum melakukan like, lakukan like
              likePost(postId, csrfToken, likeCount, likeIcon);
          }
      },
      error: function() {
          console.error('Gagal memeriksa status like.');
      }
  });
}

// Fungsi untuk melakukan like pada post
function likePost(postId, csrfToken, likeCount, likeIcon) {
  $.ajax({
      method: 'POST',
      url: '/like',
      data: { 
          postId: postId,
          _token: csrfToken
      },
      success: function(response) {
          if (response.success) {
              var newLikeCount = parseInt(likeCount.text()) + 1;
              likeCount.text(newLikeCount);
              likeIcon.addClass('liked');
          } else {
              console.error('Gagal melakukan like.');
          }
      },
      error: function() {
          console.error('Gagal melakukan like.');
      }
  });
}

// Fungsi untuk menghapus like pada post
function unlikePost(postId, csrfToken, likeCount, likeIcon) {
  $.ajax({
      method: 'DELETE',
      url: '/unlike',
      data: { 
          postId: postId,
          _token: csrfToken
      },
      success: function(response) {
          if (response.success) {
              var newLikeCount = parseInt(likeCount.text()) - 1;
              likeCount.text(newLikeCount);
              likeIcon.removeClass('liked');
          } else {
              console.error('Gagal menghapus like.');
          }
      },
      error: function() {
          console.error('Gagal menghapus like.');
      }
  });
}

function postComment(button) {
  var postId = $(button).closest('.card').data('post-id');
  var commentTextarea = $(button).siblings('.comment-textarea');
  var commentText = commentTextarea.val();
  
  // Mendapatkan token CSRF dari meta tag
  var csrfToken = $('meta[name="csrf-token"]').attr('content');

  // Kirim permintaan AJAX dengan menyertakan token CSRF dalam header
  $.ajax({
      method: 'POST',
      url: '/comment',
      headers: {
          'X-CSRF-TOKEN': csrfToken
      },
      data: {
          postId: postId,
          commentText: commentText
      },
      success: function(response) {
        if (response.success) {
            // Lakukan sesuatu setelah berhasil memposting komentar
            console.log('Komentar berhasil diposting.');
                
            // Tampilkan atau sembunyikan kotak komentar setelah sukses
            var commentBox = $(button).closest('.card').find('.comment-box');
            commentBox.toggle(); // Mengganti antara tampil atau sembunyi
            
            // Kosongkan textarea setelah berhasil memposting
            commentTextarea.val('');
        } else {
            console.error('Gagal memposting komentar.');
        }
      },    
      error: function() {
          console.error('Gagal memposting komentar.');
      }
  });
}
