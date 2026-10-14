const signUpButton=document.getElementById('signUp');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');
const listItemButton=document.getElementById('listItem');
const listItemForm=document.getElementById('listItem');

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})
listItemButton.addEventListener('click', function() {
    signInForm.style.display="none";
    signUpForm.style.display="none";
    listItemForm.style.display="block";
});

document.getElementById('signUp').onclick = function() {
    document.getElementById('signIn').style.display = 'none';
    document.getElementById('signup').style.display = 'block';
};
document.getElementById('signInButton').onclick = function() {
    document.getElementById('signup').style.display = 'none';
    document.getElementById('signIn').style.display = 'block';
};
document.getElementById('listItem').onclick = function() {
    document.getElementById('signIn').style.display = 'none';
    document.getElementById('signup').style.display = 'none';
    document.getElementById('listItem').style.display = 'block';
};

const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

