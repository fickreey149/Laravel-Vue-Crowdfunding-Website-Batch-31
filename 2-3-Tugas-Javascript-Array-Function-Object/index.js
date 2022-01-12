// Soal 1

var daftarHewan = ["2. Komodo", "5. Buaya", "3. Cicak", "4. Ular", "1. Tokek"];

daftarHewan.sort()
for (let i = 0; i < daftarHewan.length; i++) {
    console.log(daftarHewan[i])
  }

// Soal 2

function introduce(data) {
    return `Nama saya ${data.name}, umur saya ${data.age} tahun, alamat saya di ${data.address}, dan saya punya hobby yaitu ${data.hobby}!`
}
 
var data = {name : "John" , age : 30 , address : "Jalan Pelesiran" , hobby : "Gaming" }
 
var perkenalan = introduce(data)
console.log(perkenalan)

// Soal 3

function hitung_huruf_vokal(kata) {
    var k = 0
    for (let i = 0; i < kata.split('').length; i++) {
        for (let v = 0; v < vokal.length; v++) {
            if (vokal[v] == kata[i]) {
                k++
            }
            
        }
    }
    return k;
}

var vokal = ['a', 'A', 'i', 'I', 'U', 'u', 'E', 'e', 'O', 'o']

var hitung_1 = hitung_huruf_vokal("Muhammad")

var hitung_2 = hitung_huruf_vokal("Iqbal")

console.log(hitung_1 , hitung_2) // 3 2

// Soal 4

function hitung(int) {
    var nilai = 2 * int -2
    return nilai
}

console.log( hitung(0) ) // -2
console.log( hitung(1) ) // 0
console.log( hitung(2) ) // 2
console.log( hitung(3) ) // 4
console.log( hitung(5) ) // 8