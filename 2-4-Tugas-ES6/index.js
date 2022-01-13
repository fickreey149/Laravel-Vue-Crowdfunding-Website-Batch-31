// Soal 1

const luas_persegi_panjang = (panjang, lebar) => {
    return panjang * lebar
}

const keliling_persegi_panjang = (panjang, lebar) => {
    return panjang * 2 + lebar * 2
}

console.log(luas_persegi_panjang(3, 5))
console.log(keliling_persegi_panjang(3, 5))



// Soal 2

const newFunction = (firstName, lastName) => {
    return {
            fullName : () => {
            console.log(`${firstName} ${lastName}`)
        }
    }
}
   
//Driver Code 
newFunction("William", "Imoh").fullName()



// Soal 3

const newObject = {
    firstName: "Muhammad",
    lastName: "Iqbal Mubarok",
    address: "Jalan Ranamanyar",
    hobby: "playing football",
}

const { firstName, lastName, address, hobby } = newObject

// Driver code
console.log(firstName, lastName, address, hobby)



// Soal 4

const west = ["Will", "Chris", "Sam", "Holly"]
const east = ["Gill", "Brian", "Noel", "Maggie"]
const combined = [ ...west, ...east ]
//Driver Code
console.log(combined)


// Soal 5

const planet = "earth" 
const view = "glass" 
let before = `Lorem ${view} dolor sit amet, consectetur adipiscing elit, ${planet}`

console.log(before)