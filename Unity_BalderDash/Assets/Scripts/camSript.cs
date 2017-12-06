using UnityEngine;
using System.Collections;

public class camSript : MonoBehaviour {

    public int rnd;
	// Use this for initialization
	void Start () {
        rnd = 1;
	
	}
	
	// Update is called once per frame
	void Update () {
	
	}

    public int getRnd()
    {
        return rnd;
    }
    public void setRnd()
    {
        rnd++;
    }
}
