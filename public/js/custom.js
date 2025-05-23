function star(obj, klass){
  const elements = document.querySelectorAll(klass);
  elements.forEach(element => {
    if(element.getAttribute('value')>obj.getAttribute('value')){
      element.style.color='grey';
    }else{
      element.style.color='gold';
    }
    console.log(element); // Example: log the element to the console
    console.log(obj.value); // Example: log the element to the console
});
}