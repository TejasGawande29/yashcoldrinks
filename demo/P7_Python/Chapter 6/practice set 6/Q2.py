#1- all three sub must have marks grater than 33.
#2- average of all three sub must be grater than 40.


cps = int(input("Enter marks of Computer Programming: "))
maths = int(input("Enter marks of Mathematics: "))
physics = int(input("Enter marks of physics: "))

avg = (cps + maths + physics)/3

if cps>33 and maths>33 and physics>33:
  if avg>40:
    print("Your are pass")
  else:
    print("Your are fail")
else:
  print("Your are fail")

x