document.addEventListener('DOMContentLoaded', function () {


    });
    
// función para hashear password con SHA-256
async function hashPassword(password) {
    // convertir string a ArrayBuffer
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    
    // crear hash SHA-256
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    
    // convertir a hexadecimal
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    
    return hashHex;
}