s = int(input("Enter Semiperimeter of triangle: "))
a = int(input("Enter length of side a: "))
b = int(input("Enter length of side b: "))
c = int(input("Enter length of side c: "))

area = (s*(s-a)*(s-b)*(s-c)) ** 0.5
print("Area of triangle is: ", area)