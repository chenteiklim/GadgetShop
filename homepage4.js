const BASE_URL="http://localhost/Project/EnterpriseProject/api.php"

window.onload=()=>{
    displayProductData2();
}

async function getProductData2(){
    const response=await fetch(BASE_URL)
    const productData2= await response.json()
    console.log(productData2)
    return productData2
}

async function displayProductData2(){
    let productData2 = await getProductData2()
    for(let ID =0; ID<productData2.length;ID++){
        let image = productData2[ID].image;
        const product_name=productData2[ID].product_name
        const status=productData2[ID].status
        const price=productData2[ID].price
        let ratings = productData2[ID].rating
    

    const container=document.querySelector('#container')
  
    console.log(product_name)
        let newProduct2 = `
            <div id="product-${ID}" class="ID"><!--Use for design product container-->
            <div class="imageContainer">

                <img id="image-${ID}" class="image" src="${image}" alt="" >
            </div>
            <div id="name-${ID}" class="name">${product_name}</div>
            <div id="price-${ID}" class="price">
                <div id=unit-${ID} class="unit">RM</div>
                <div id="price-${ID}">${price}</div>
            </div>
            <div id='rating'>
            `
            for (let i = 1; i <= ratings; i++) {
                newProduct2 += `
                <span class="fa fa-star checked"></span>
                `;
            }
            for (let i = ratings+1; i <=5 ; i++) {
                newProduct2 += `
                <span class="fa fa-star"></span>
                `;
            }
            newProduct2+=`<div id="status-${ID}" class="status">${status} sold</div>` 
            newProduct2 +=`</div>`     
            newProduct2+= `<button id="btn-${ID}" onclick="view(${ID})"  class ="btn" type="button">View</button>`
            
            container.innerHTML+=newProduct2
        }
}
  
function view(ID){
    console.log(ID)
    if (ID === 0) {
        window.location.href = 'keyboard.html';
      } else if (ID === 1) {
        window.location.href = 'mouse.html';
      }
      else if (ID === 2) {
        window.location.href = 'mousepad.html';
      }   
      else if (ID === 3) {
        window.location.href = 'monitor.html';
      }   
      else if (ID === 4) {
        window.location.href = 'earbud.html';
      }   
      else if (ID === 5) {
        window.location.href = 'headset.html';
      }   
      else if (ID === 6) {
        window.location.href = 'casing.html';
      }   
}
