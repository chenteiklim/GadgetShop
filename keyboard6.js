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
        const quantityInput = document.getElementById('quantity_input');

    const container=document.querySelector('#container')
    let newProduct2 = `
        <div id="container">
            <div>
            <img class="keyboard" src="${image}" alt="">
            </div>
            <div>
            <div class="names">${name}</div>
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
            newProduct2+=`<div id="price-${0}" class="prices">RM${price}</div>` 
            newProduct2+=`
            <form action="order.php" method="post">
            <div class=quantity>
                <label for="quantity" class=quantity_label>Quantity:</label>
                <button id="increment">+</button>
                <input type="number" id="quantity_input" name="quantity_input" min="1" value="1">
                <button id="decrement">-</button>
            </div>
            <div>
                <input id="addCartBtn" class="button" type="submit" name="addOrder" value="Add To Cart">
            </div>
            </form>
            ` 
            newProduct2 +=`</div>`
    container.innerHTML+=newProduct2

const quantity_input=document.getElementById('quantity_input');  
const incrementButton = document.getElementById('increment');

incrementButton.addEventListener('click', function(event) {
    event.preventDefault();
    currentValue = parseInt(quantity_input.value)
    quantity_input.value=currentValue+1
});
const decrementButton = document.getElementById('decrement');

decrementButton.addEventListener('click', function(event) {
    if (currentValue>1){
        event.preventDefault();
        let currentValue = parseInt(quantity_input.value)
        quantity_input.value = currentValue - 1;
    }
    else{
        event.preventDefault();
    }
})

}

  
    