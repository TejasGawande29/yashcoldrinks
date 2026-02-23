num1 = int(input("enter the first number: "))
num2 = int(input("enter the second number: "))
num3 = int(input("enter the third number: "))
num4 = int(input("enter the fourth number: "))

if num4>num1 and num4>num2 and num4>num3:
  print("gratest is:" , num4)
elif num3>num1 and num3>num2 and num3>num4:
  print("gratest is:" , num3)
elif num2>num1 and num2>num3 and num2>num4:
  print("gratest is:" , num2)
else:
  print("gratest is:" , num1)

 