<template>

</template>

<script>
export default {

}
</script>

<style>

.wrapper{
  display: inline-flex;
  align-items: center;
  justify-content: space-evenly;
  border-radius: 5px;
}
.option{
    min-height: 39px;
    min-width: 100px;
    padding: .2rem 1rem;
    background: #fff;
    height: 100%;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    margin: 0 8px;
    border-radius: 5px;
    cursor: pointer;
    border: 2px solid lightgrey;
    transition: all 0.3s ease;
}
.option:first-child {
  margin-left: 0;
}
.option:last-child {
  margin-right: 0;
}
.option .dot{
  height: 16px;
  width: 16px;
  background: #d9d9d9;
  border-radius: 50%;
  position: relative;
}
.option .dot::before{
  position: absolute;
  content: "";
  top: 4px;
  left: 4px;
  width: 8px;
  height: 8px;
  background: #5B73E8;
  border-radius: 50%;
  opacity: 0;
  transform: scale(1.5);
  transition: all 0.3s ease;
}
input[type="radio"]{
  display: none;
}
#option-1:checked:checked ~ .option-1,
#option-2:checked:checked ~ .option-2,
#option-3:checked:checked ~ .option-3{
  border-color: #5B73E8;
  background: #5B73E8;
}
#option-1:checked:checked ~ .option-1 .dot,
#option-2:checked:checked ~ .option-2 .dot,
#option-3:checked:checked ~ .option-3 .dot{
  background: #fff;
}
#option-1:checked:checked ~ .option-1 .dot::before,
#option-2:checked:checked ~ .option-2 .dot::before,
#option-3:checked:checked ~ .option-3 .dot::before{
  opacity: 1;
  transform: scale(1);
}
.option span{
  font-size: 16px;
  color: #808080;
}
#option-1:checked:checked ~ .option-1 span,
#option-2:checked:checked ~ .option-2 span,
#option-3:checked:checked ~ .option-3 span{
  color: #fff;
}
</style>
