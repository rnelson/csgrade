package org.pretendamazing.csgrade.util.conf;
import java.util.ArrayList;

public class LabPart {
	public String name;
	public String mainSource;
	public ArrayList<String> source;
	public String binary;
	public String type;
	public String matchType;
	public String solutionBinary;
	public String solutionText;
	public int solution;
	public String makefile;
	public String mossGlob;
	public ArrayList<String> mossBaseFile;

	public LabPart() {
		this.binary = "a.out";
		
		// Set blank values for things that the user *must* specify
		this.name = "";
		this.mainSource = "";
		this.type = "";
		this.matchType = "";
		this.solutionBinary = "";
		this.solutionText = "";
		this.solution = 0;
		this.makefile = "";
		this.mossGlob = "";
		
		// Initialize the lists
		this.source = new ArrayList<String>();
		this.mossBaseFile = new ArrayList<String>();
	}
}
