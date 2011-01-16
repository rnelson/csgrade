package org.pretendamazing.csgrade.util.conf;
import java.util.ArrayList;

public class Lab {
	public boolean complete;
	public int number;
	public String name;
	public String shortName;
	public String directory;
	public ArrayList<LabPart> part;
	public int numberOfParts; // NOTE: this needs to be updated
	
	public Lab() {
		// Set default settings where applicable
		this.complete = true;
		
		// Set blank values for things that the user *must* specify
		this.number = 0;
		this.name = "";
		this.shortName = "";
		this.directory = "";
		
		// Initialize the list of parts
		this.part = new ArrayList<LabPart>();
	}
}
