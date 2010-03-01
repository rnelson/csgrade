#!/usr/bin/python
import os
import sys
import subprocess
import tempfile


# Script configuration
globals = {
	'name':       'cse@unl tester',
	'version':    '0.0.1',
	'author':     'Ross Nelson <rnelson@cse>',
	'compiler':   '/usr/bin/gfortran',
	'root':       '/home/grad/Classes_102/cse150efl/webhandin',
	'homedir':    '/home/grad/Classes_102/cse150efl',
	'instructor': 'Ross'
}

def getLab():
	return {
		'num':       '',
		'name':      '',
		'shortname': '',
		'numparts':  '',
		'dir':       '',
		'parts':     None
	}

def getLabPart():
	return {
		'name':      '',
		'source':    '',
		'binary':    '',
		'type':      '',
		'matchtype': '',
		'solbin':    '',
		'soltxt':    '',
		'solution':  ''
	}

def getGradeRet():
	return {
		'output':     '',
		'result':     '',
		'compOutput': '',
		'runOutput':  '',
		'diffOutput': ''
	}

def getCompileRet():
	return {
		'command': '',
		'result':  '',
		'retval':  ''
	}

def getRunRet():
	return {
		'command': '',
		'result':  '',
		'retval':  ''
	}

def getLabDir(lab):
	return os.path.join(os.path.join(globals['root'], lab), 'unix')

def getBinaryPath(binaryName):
	return os.path.join(os.path.join(globals['homedir'], 'bin'), binaryName)

# Assignments
## Lab 7
lab7part1 = getLabPart()
lab7part1['name'] = 'ex1'
lab7part1['source'] = 'week7-ex1.f95'
lab7part1['binary'] = 'a.out'
lab7part1['type'] = 'intmatch'
lab7part1['matchtype'] = 'static'
lab7part1['solution'] = 681
lab7 = getLab()
lab7['num'] = 7
lab7['name'] = 'Week 7'
lab7['shortname'] = 'wk7'
lab7['numparts'] = 1
lab7['dir'] = getLabDir('7')
lab7['parts'] = []
lab7['parts'].append(lab7part1)
## Lab 8
lab8part1 = getLabPart()
lab8part1['name'] = 'ex1'
lab8part1['source'] = 'week8.f95'
lab8part1['binary'] = 'a.out'
lab8part1['type'] = 'binmatch'
lab8part1['solbin'] = getBinaryPath('week8-reference')
lab8 = getLab()
lab8['num'] = 8
lab8['name'] = 'Week 8'
lab8['shortname'] = 'wk8'
lab8['numparts'] = 1
lab8['dir'] = getLabDir('8')
lab8['parts'] = []
lab8['parts'].append(lab8part1)

assignments = []
assignments.append(lab7)
assignments.append(lab8)


# Deal with command line arguments
grading = False
assignment = len(assignments) # default assignment

# TODO: this should be replaced with OptParse stuff
if len(sys.argv) > 1:
	# Copy the arguments and get rid of 'test.py'
	args = sys.argv
	del args[0]
	
	for a in sys.argv:
		# Remove spaces on the ends
		arg = a.strip()
		
		# Check for flags
		if arg.startswith('-'):
			if arg == '-g':
				grading = True
		else:
			# If it's not a flag, it's an argument number
			try:
				num = int(arg)
				assignment = num
			except:
				print 'Error: assignment ' + arg + ' does not exist'
				sys.exit(1)


# Variables
grades = []


# Utility functions
def mktmpnam():
	f = tempfile.NamedTemporaryFile()
	tmp = f.name
	f.close()
	return tmp

def exists(filename):
	return os.path.exists(filename)

def unlink(filename):
	if filename == None:
		return
	
	if os.path.exists(filename):
		os.unlink(filename)

def findLab(number):
	for l in assignments:
		if l['num'] == number:
			return l
	
	return None

def compile(student, lab, part, bin, src, showOutput=False, outputFilename='', compiler=globals['compiler']):
	ret = getCompileRet()
	
	# If the file doesn't exist, save time and flag it as such here
	if not exists(src):
		ret['retval'] = -1
		ret['result'] = '(-) "' + src + '" does not exist'
		ret['output'] = ''
		return ret
	
	# Base compilation command
	command = compiler + ' -o ' + bin + ' ' + src
	
	# What do we do with the output?
	out = ''
	outStdout = ''
	outStderr = ''
	
	if not showOutput:
		out = '>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()
		
		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out
	
	# Save the command used
	ret['command'] = command
	
	# Compile the code
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval
	
	# Log the results
	if retval == 0:
		ret['result'] = '( ) Compiled'
	else:
		ret['result'] = '(-) Compilation error'
	
	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()
	
	return ret

def run(student, lab, part, bin, showOutput=False, outputFilename=''):
	ret = getRunRet()

	# Base command
	command = bin

	# What do we do with the output?
	out = ''
	if not showOutput:
		out = '>/dev/null'
	else:
		outStdout = mktmpnam()
		outStderr = mktmpnam()

		out = '>' + outStdout + ' 2>' + outStderr
	command = command + ' ' + out

	# Save the command used
	ret['command'] = command

	# Run the program
	retval = subprocess.call(command, shell=True)
	ret['retval'] = retval

	# Log the results
	if retval == 0:
		ret['result'] = '( ) Ran successfully'
	else:
		ret['result'] = '(-) Program crashed'

	# If the user requested output saved to a file, we need to get it from two files into one
	if showOutput and outputFilename != '':
		stdoutFile = open(outStdout, 'r')
		stderrFile = open(outStderr, 'r')
		outfile = open(outputFilename, 'w')
		
		for line in stdoutFile:
			outfile.write(line)
		for line in stderrFile:
			outfile.write(line)
		
		stdoutFile.close()
		stderrFile.close()
		outfile.close()

	return ret


# Grading functions
def gradeIntmatch(student, lab, part, solution):
	# Variables
	ret = getGradeRet()
	ldir = lab['dir']
	binpath = part['binary']
	srcpath = part['source']
	compRet = getCompileRet()
	runRet = getRunRet()
	
	if grading:
		binpath = os.path.join(ldir, part['binary'])
		srcpath = os.path.join(ldir, part['source'])
	
	# Compile the code
	if grading:
		compRet = compile(student, lab, part, binpath, srcpath)
	else:
		ret['compOutput'] = mktmpnam()
		compRet = compile(student, lab, part, binpath, srcpath, True, ret['compOutput'])
	
	# If it didn't error out, run it
	if compRet['retval'] != 0:
		ret['result'] = compRet['result']
		ret['output'] = ret['compOutput']
		
		if ret['result'] == '(-) "' + srcpath + '" does not exist':
			ret['output'] = ''
		return ret
	else:
		# We want to save the output to a file in all cases since we'll be
		# determining correctness by reading from it
		ret['runOutput'] = mktmpnam()
		runRet = run(student, lab, part, binpath, True, ret['runOutput'])
	
	# Did the program run correctly?
	if runRet['retval'] != 0:
		ret['result'] = runRet['result']
		ret['output'] = ret['runOutput']
		return ret
	else:
		ret['output'] = None
		runres = '(-) Wrong output'
		
		try:
			f = open(ret['runOutput'], 'r')
		
			try:
				number = int(f.read())
		
				if number == solution:
					runres = '(+) Correct'
			except:
				pass
		
			f.close()
		except:
			pass
		
		ret['result'] = runres
	
	return ret











###############################

if __name__ == '__main__':
	# Find the lab we want to check
	lab = findLab(assignment)
	if lab == None:
		print 'Error: cannot find lab structure; notify ' + globals['instructor']
		sys.exit(2)
	
	# Do the actual testing/grading
	if not grading:
		student = os.environ.get('USER')
		ret = None
		
		for part in lab['parts']:
			pType = part['type']
			
			if pType == 'binmatch':
				pass
			elif pType == 'txtmatch':
				pass
			elif pType == 'intmatch':
				solution = None
				
				if part['matchtype'] == 'bin':
					out = mktmpnam()
					command = part['solbin'] + ' > ' + out
					subprocess.call(command, shell=True)
					
					f = open(out, 'r')
					solution = int(f.read())
					f.close()
				elif part['matchtype'] == 'txt':
					f = open(part['soltxt'], 'r')
					solution = int(f.read())
					f.close()
				elif part['matchtype'] == 'static':
					solution = part['solution']
				
				# Compile + run the code
				ret = gradeIntmatch(student, lab, part, solution)
			else:
				print 'Error: don\'t know how to grade ' + lab['name'] + ' ' + part['name']
				sys.exit(3)
			
			
			# Print the results
			print student + '/' + lab['shortname'] + part['name'] + ':  ' + ret['result']
			
			if ret['output'] != None and ret['output'] != '':
				print ''
				print 'Output:'
				
				# There was an error somewhere; print the file contents
				f = open(ret['output'], 'r')
				for line in f:
					print '   ' + line.rstrip()
				f.close()
			
			
			# Clean up the files we used
			unlink(ret['compOutput'])
			unlink(ret['runOutput'])
			unlink(ret['diffOutput'])
	else:
		for d in os.listdir(ASSDIR):
			if os.path.isdir(os.path.join(ASSDIR, d)):
				student = d
				sdir = os.path.join(ASSDIR, d)
			
				if exists(os.path.join(sdir, ex1source)):
					gradeEx1(sdir)
				else:
					grades.append(student + ': (ex1) MISSING')
			
				if exists(os.path.join(sdir, ex2source)):
					gradeEx2(sdir)
				else:
					grades.append(student + ': (ex2) MISSING')
	
		print ''
		grades.sort()
		for g in grades:
			print g
