function svgturkiyeharitasi() {
  const element = document.querySelector('#svg-turkiye-haritasi');
  const info = document.querySelector('.il-isimleri');
  let currentIlAdi = ''; // İl adını saklamak için bir değişken ekleyelim
  let currentCategories = []; // Kategoriler bilgisini saklayalım
  let currentProducts = []; // Ürünleri saklamak için bir değişken ekleyelim

  element.addEventListener('mouseover', function (event) {
    if (event.target.tagName === 'path') {
      info.innerHTML = `<div>${event.target.parentNode.getAttribute('data-iladi')}</div>`;
    }
  });

  element.addEventListener('mousemove', function (event) {
    info.style.top = event.pageY + 25 + 'px';
    info.style.left = event.pageX + 'px';
  });

  element.addEventListener('mouseout', function () {
    info.innerHTML = '';
  });

  // PHP'den kategori verilerini almak için fonksiyon
  function fetchCategoriesByIl(ilAdi) {
    fetch(`../php/db_connect.php?action=get_categories_by_il&ilAdi=${ilAdi}`)
      .then(response => response.json())
      .then(data => {
        if (data.categories) {
          currentCategories = data.categories; // Kategorileri sakla
          renderCategoriesModal(data.categories, ilAdi);
        } else {
          alert('Kategori bulunamadı.');
        }
      })
      .catch(error => {
        console.error('Hata:', error);
      });
  }

  // Kategorilerin modalda görüntülenmesi
  function renderCategoriesModal(categories, ilAdi) {
    const modal = document.querySelector('.modal[data-modal="trigger-2"] .content-wrapper');

    categories.sort((a, b) => a.localeCompare(b));  // Kategorileri alfabetik sıralama
    let categoryContent = `
      <button class="close-modal action">X</button>
      <header class="modal-header">
        <h2>${ilAdi}</h2>
      </header>
      <div class="category-list">
        ${categories.length > 0 ? categories.map(category => 
          `<div class="category-item" data-category="${category}">${category}</div>` // Kategorilere tıklanabilir sınıf ekleniyor
        ).join('') : '<div class="no-categories">Kategori bulunamadı.</div>'}
      </div>
    `;
    
    modal.innerHTML = categoryContent;
    openModal("trigger-2");

    // Kapatma butonuna tıklama işlevi
    const closeButton = document.querySelector('.close-modal');
    closeButton.addEventListener('click', function () {
      closeModal("trigger-2");
    });

    // Kategorilere tıklama işlevi
    document.querySelectorAll('.category-item').forEach(item => {
      item.addEventListener('click', function () {
        const category = item.getAttribute('data-category');
        fetchProductsByCategory(category);  // Ürünleri almak için fonksiyonu çağır
      });
    });
  }

  // Kategorinin ürünlerini almak ve gösterme fonksiyonu
  function fetchProductsByCategory(kategoriAdi) {
    fetch(`../php/db_connect.php?action=get_products_by_category&kategoriAdi=${kategoriAdi}`)
      .then(response => response.json())
      .then(data => {
        if (data.products) {
          currentProducts = data.products; // Ürünleri sakla
          renderProductsModal(data.products, kategoriAdi);
        } else {
          alert('Ürün bulunamadı.');
        }
      })
      .catch(error => {
        console.error('Hata:', error);
      });
  }

  // Ürünlerin modalda görüntülenmesi
  function renderProductsModal(products, kategoriAdi) {
    const modal = document.querySelector('.modal[data-modal="trigger-2"] .content-wrapper');

    let productContent = `
      <button class="close-modal action">X</button>
      <button class="back-to-categories action">&lt;</button> <!-- Geri butonu '<' olarak değiştirildi -->
      <header class="modal-header">
        <h2>${kategoriAdi} Ürünleri</h2>
      </header>
      <div class="product-list">
        ${products.length > 0 ? products.map(product =>
          `<div class="product-item">
            <h3>${product.adi}</h3> <!-- Ürün adını 'adi' olarak güncelledim -->
            <p>${product.aciklama}</p> <!-- Ürün açıklamasını 'aciklama' olarak güncelledim -->
          </div>`).join('') : '<p>Ürün bulunamadı.</p>'}
      </div>
    `;
    
    modal.innerHTML = productContent;

    // Geri butonuna tıklama işlevi
    const backButton = document.querySelector('.back-to-categories');
    backButton.addEventListener('click', function () {
      renderCategoriesModal(currentCategories, currentIlAdi); // Kategorileri geri render ediyoruz
    });

    // Ürünlere tıklama işlevi ekleniyor
    document.querySelectorAll('.product-item').forEach(item => {
      item.addEventListener('click', function () {
        const urunAdi = item.querySelector('h3').textContent;
        const urunAciklama = item.querySelector('p').textContent;
        fetchProducersByProduct(urunAdi, urunAciklama); // Üreticileri al
      });
    });
  }

  // Ürüne tıklandığında üreticileri getiren fonksiyon
  function fetchProducersByProduct(urunAdi, urunAciklama) {
    fetch(`../php/db_connect.php?action=get_producers_by_product&urunAdi=${encodeURIComponent(urunAdi)}&urunAciklama=${encodeURIComponent(urunAciklama)}`)
        .then(response => response.json())
        .then(data => {
            if (data.producers) {
                renderProducersModal(data.producers, urunAdi);
            } else {
                alert('Üretici bulunamadı.');
            }
        })
        .catch(error => {
            console.error('Hata:', error);
        });
  }

  function renderProducersModal(producers, urunAdi) {
    const modal = document.querySelector('.modal[data-modal="trigger-3"] .content-wrapper');

    let producerContent = `
      <button class="close-modal action">X</button>
      <button class="back-to-categories action">&lt;</button>
      <header class="modal-header">
        <h2>${urunAdi} Üreticileri</h2>
      </header>
      <div class="producer-list">
        ${producers.length > 0 ? producers.map(producer => `
          <div class="producer-item">
            <h3>${producer.adi} ${producer.soyadi}</h3>
            <p><strong>E-posta:</strong> ${producer.eposta}</p>
            <p><strong>Telefon:</strong> ${producer.telefon}</p>
            <p><strong>Adres:</strong> ${producer.adres}</p>
            <div class="reviews" data-producer-id="${producer.uretici_id}">
              <h4>Yorumlar:</h4>
              <p>Yükleniyor...</p>
            </div>
            <div class="add-review">
              <label for="new-review-${producer.uretici_id}">Yorum Yap:</label>
              <div class="rating-container">
                <span class="star" data-value="1"></span>
                <span class="star" data-value="2"></span>
                <span class="star" data-value="3"></span>
                <span class="star" data-value="4"></span>
                <span class="star" data-value="5"></span>
              </div>
              <textarea id="new-review-${producer.uretici_id}" placeholder="Yorumunuzu yazın..." maxlength="200"></textarea>
              <button class="submit-review" data-producer="${producer.uretici_id}">Gönder</button>
            </div>
          </div>
        `).join('') : '<p>Üretici bulunamadı.</p>'}
      </div>
    `;

    modal.innerHTML = producerContent;

    // Mevcut yorumları getirme
    producers.forEach(producer => fetchReviews(producer.uretici_id));

    // Yıldız seçimi ve yorum gönderme işlevselliği
    document.querySelectorAll('.producer-item').forEach(producerItem => {
        let selectedRating = 0;

        producerItem.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function () {
                const value = parseInt(this.getAttribute('data-value'));
                selectedRating = selectedRating === value ? 0 : value; // Tıklanan yıldızı seç veya kaldır
                producerItem.querySelectorAll('.star').forEach(innerStar => {
                    innerStar.classList.toggle('selected', parseInt(innerStar.getAttribute('data-value')) <= selectedRating);
                });
            });
        });

        producerItem.querySelector('.submit-review').addEventListener('click', function () {
          const textarea = producerItem.querySelector(`#new-review-${this.dataset.producer}`);
          const newReview = textarea.value.trim();
          const ureticiId = this.dataset.producer;
      
          if (!newReview) {
              alert("Lütfen yorumunuzu yazın.");
              return;
          }
          if (selectedRating === 0) {
              alert("Lütfen bir puan seçin.");
              return;
          }
      
          // Yorum gönderme işlemi
          fetch('../php/db_connect.php?action=add_review', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: `ureticiId=${encodeURIComponent(ureticiId)}&yorum=${encodeURIComponent(newReview)}&puan=${selectedRating}`
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert(data.message);
                  const reviewContainer = producerItem.querySelector('.reviews');
                  const newReviewElement = document.createElement('div');
                  newReviewElement.className = 'review';
                  newReviewElement.innerHTML = `
                      <p><strong>Kullanıcı:</strong> ${newReview}</p>
                      <p>Puan: ${'⭐'.repeat(selectedRating)}</p>
                  `;
                  reviewContainer.appendChild(newReviewElement);
      
                  textarea.value = ""; // Alanı temizle
                  producerItem.querySelectorAll('.star').forEach(star => star.classList.remove('selected'));
              } else {
                  alert(data.message);
              }
          })
          .catch(error => console.error("Hata:", error));
      });
      
    });

    openModal("trigger-3");

    const backButton = modal.querySelector('.back-to-categories');
    backButton.addEventListener('click', function () {
        closeModal("trigger-3"); 
        renderProductsModal(currentProducts, kategoriAdi); 
    });

    const closeButton = modal.querySelector('.close-modal');
    closeButton.addEventListener('click', function () {
        closeModal("trigger-3"); 
        closeModal("trigger-2");
        closeModal("trigger-1");
    });
}

// Yeni fetchReviews fonksiyonu
function fetchReviews(producerId) {
  fetch(`../php/db_connect.php?action=get_reviews_by_producer&ureticiId=${producerId}`)
      .then(response => {
          if (!response.ok) {
              throw new Error(`HTTP Error! Status: ${response.status}`);
          }
          return response.text(); // Metin olarak yanıt al
      })
      .then(text => {
          try {
              const data = JSON.parse(text); // Metni JSON'a dönüştür
              const reviewsContainer = document.querySelector(`.reviews[data-producer-id="${producerId}"]`);
              if (data.reviews && data.reviews.length > 0) {
                  reviewsContainer.innerHTML = data.reviews.map(review => `
                      <div class="review">
                          <p><strong>${review.kullanici}:</strong> ${review.yorum}</p>
                          <p>Puan: ${'⭐'.repeat(review.puan)}</p>
                      </div>
                  `).join('');
              } else {
                  reviewsContainer.innerHTML = '<p>Henüz yorum yapılmamış.</p>';
              }
          } catch (error) {
              console.error("JSON Parsing Error:", error, text); // JSON hatasını konsola yazdır
              throw new Error("Geçersiz JSON formatı.");
          }
      })
      .catch(error => {
          console.error('Hata:', error);
          const reviewsContainer = document.querySelector(`.reviews[data-producer-id="${producerId}"]`);
          reviewsContainer.innerHTML = '<p>Yorumlar yüklenirken bir hata oluştu.</p>';
      });
}

  // Modal açma fonksiyonu
  function openModal(modalId) {
    const modal = document.querySelector(`.modal[data-modal="${modalId}"]`);
    modal.classList.add('open');
    modal.style.height = '100vh';
  }

  // Modal kapama fonksiyonu
  function closeModal(modalId) {
    const modal = document.querySelector(`.modal[data-modal="${modalId}"]`);
    modal.classList.remove('open');
    modal.style.height = '0';
  }

  // İl üzerine tıklama işlemi
  element.addEventListener('click', function (event) {
    if (event.target.tagName === 'path') {
      const parent = event.target.parentNode;
      const ilAdi = parent.getAttribute('data-iladi');
      currentIlAdi = ilAdi; // İl adını sakla
      // Seçilen il adı ile PHP'ye istek gönder
      fetchCategoriesByIl(ilAdi);
    }
  });
}

document.addEventListener('click', (event) => {
  if (event.target.classList.contains('close-modal')) {
    const modal = event.target.closest('.modal');
    modal.classList.remove('open');
    modal.style.height = '0';
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const navButtons = document.querySelector('.nav-buttons');

  // Kullanıcı oturum bilgilerini kontrol et
  fetch('../php/get_user_info.php')
      .then(response => response.json())
      .then(data => {
          if (data.isLoggedIn) {
              // Kullanıcı giriş yaptıysa butonları güncelle
              navButtons.innerHTML = `
                  <button 
                      class="button logout-button" 
                      onclick="logout()">Çıkış</button>
                  <button 
                      class="button login-button" 
                      disabled>${data.userName}</button>
              `;
          } else {
              // Kullanıcı giriş yapmadıysa varsayılan butonları göster
              navButtons.innerHTML = `
                  <a href="../php/kullanici_kayit.php" class="link">Kayıt Ol</a>
                  <button class="button" onclick="window.location.href='../php/login.php'">Giriş Yap</button>
              `;
          }
      })
      .catch(error => {
          console.error('Kullanıcı bilgileri alınamadı:', error);
      });
});

function logout() {
  fetch('../php/logout.php', { method: 'POST' })
      .then(() => {
          window.location.href = '../html/proje.html';
      })
      .catch(error => {
          console.error('Çıkış işlemi başarısız:', error);
      });
}


svgturkiyeharitasi();
