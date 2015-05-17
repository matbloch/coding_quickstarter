%% ============================================================
%%  	EQUATION SOLVING
%% ============================================================


syms x
eqn = sin(x) == 1;
solve(eqn, x)

% more than one variable
syms a b
[b, a] = solve(a + b == 1, 2*a - b == 4, b, a)


%% ============================================================
%%  	STRUCTURES - INITIALIZATION
%% ============================================================

A(m by n) = [a11, a12, a13; a21, a22, a23; a31, a32, ..., a_mn]    % m = nr rows (zeilen), n = nr columns (spalten)

% === Matrices

A = [1 2; 3 4];
A = eye(n,m);			% n x m identity matrix
A = zeros(n, m);		% n x m zeros matrix

% === Vectors

v = 0:3;							% [0, 1, 2, 3]
v = linspace(a, b, n);		% from a to b in n steps

%% =============  STRUCTURES - SLICING  ============= %%

v(1)						% first element
v([1,3])					% 1 + 3 element
v(2:end)				% 2 till end
v(3,7)					% 3-7 element
v([2:4 5:8])			% 2-4, 5-8

A(y,x)						% select field with (x,y) pos
A(2:4, 1:2)				%
A(3, :)						% extract third row

p(:,:,1) = [0.2, 0.7;0.1, 0.9]		% select all y & x, in 1st 3dim
p(:,:,2) = [0.2, 0.7;0.1, 0.9]		% select all y & x, in 2nd 3dim

A(:, end);					% extract last column
A([2,3,4], [1,2,4])


% intersection
A = [7 1 7 7 4]; B = [7 0 4 4 0];
C = intersect(A,B) % Find the values common to both A and B.
% find elements in array
if any(A<123),
      %...
end

%% functions

size(A, dim)  % nr rows: dim = 1, nr cols: dim = 2


%% ---------  column wise operations


% subtract vector y from each column of x: x-y
bsxfun(@minus, x,y)


%% ---------  sum

A = [ 1 1 1; 0 1 0]; 
>> sum(A)

ans =

     1     2     1

>> A

A =

     1     1     1
     0     1     0

>> sum(A,2)

ans =

     3
     1

	 
%% ============================================================
%%  	USER INTERFACE
%% ============================================================
	
% inputs
height = input('Enter your height in meters: ');

imshow('moon.tif')
[x, y] = getpts()
[x, y] = getline()
rect = getrect

% message
msgbox('Done collecting points');

% button box
maxAllowablePoints = 5; % Whatever you want.
promptMessage = sprintf('Left click up to %d points.\nRight click when done.', maxAllowablePoints);
titleBarCaption = 'Continue?';
button = questdlg(promptMessage, titleBarCaption, 'Continue', 'Cancel', 'Continue');
if strcmpi(button, 'Cancel')
	return;
end
	
%% ============================================================
%%  	STRUCTURES - OPERATIONS
%% ============================================================	





%% =============  STRUCTS  ============= %%


s = struct(fieldname1,value1,...,fieldnameN,valueN)


s.fieldname1 = 123;		% set/access field

%% =============  CONTROL STRUCTURES  ============= %%

for i = 1:N

	% do something
	
end

% === While

while(criteria)

end

% === if/elseif/else

if(crit1)

elseif(crit2)

else

end

% === switch

switch switch_expression
   case case_expression
      statements
   case case_expression
      statements
    ...
   otherwise
      statements
end

%% =============  SOLVING SYSTEMS  ============= %%

• Linear systems: A*x = B

syms x y z  % with parameters
A = [x 2*x y; x*z 2*x*z y*z+z; 1 0 1];
B = [z y; z^2 y*z; 0 0];
X = linsolve(A, B)



• Equations to linear equation matrix form
syms x y z
[A, b] = equationsToMatrix([x + y - 2*z == 0, x + y + z == 1,... ,2*y - z + 5 == 0], [x, y, z])

% or: (without variable specification)
syms s t
[A, b] = equationsToMatrix([s - 2*t + 1 == 0, 3*s - t == 10])


%% =============  CONSOLE  ============= %%


clear;		%% delete all variables
clc;		     %% clear command window
print(v);	% output to console
fprintf('Minimal speed : %f m/s.\n', a_v);		% plot with variable on same line

%% =============  ESCAPING  ============= %%


'my''string';			% escape ' with another '

'%%'					% double % in sprintf
'\\'						% double \ in sprintf



%% =============  EXTERNAL DATA ============= %%



%% =============  MISC FUNCTION  ============= %%

length(v);			% vector length
[m, n] = size(A);
abs();				% absolute value
sum(v);			% sum up vector elements


[val idx] = max(a);		% max value and index


index = find(v == 2.324);		% get the index of the value

%% =============  PLOTTING  ============= %%


plot(x,y, 'color', 'red');							%% x/y vector plot
xlabel('X-Achse');
ylabel('Y-Achse');

scatter(x,y);		% creates a scatter plot with circles at the locations specified by the vectors x and y. This type of graph is also known as a bubble plot.



%% =============  FUNCTIONS  ============= %%