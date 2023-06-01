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
        let image = productData2[0].image;
        const name=productData2[0].name
        const status=productData2[0].status
        const price=productData2[0].price
        const quantity=productData2[0].quantity
        let ratings = productData2[0].rating
    
    const container=document.querySelector('#container')
    let newProduct2 = `
        <div id="container">
            <div>
            <img class="keyboard" src="${image}" alt="">
            </div>
            <div>
            <div class="name">${name}</div>
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
            newProduct2+=`<div id="status-${0}" class="status">${status} sold</div>` 
            newProduct2 +=`</div>`
            newProduct2+=`<div id="price-${0}" class="price">RM${price}</div>` 
            newProduct2+=`
            <form action="addToCart.php" method="post">
            <input id="addCartBtn" class="button" type="submit" name="submit" value="Add To Cart">
            </form>
            ` 
            newProduct2 +=`</div>`
    container.innerHTML+=newProduct2
}

  
    