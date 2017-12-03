using UnityEngine;
using UnityEngine.UI;
using System.Collections;

public class wordDef : MonoBehaviour {

    public Text timer;
    public GameObject defSelect;
    float time;

	// Use this for initialization
	void Start () {
        time = 15;
	}
	
	// Update is called once per frame
	void Update ()
    {
        time -= Time.deltaTime;
        if(time < 0)
        {
            time = 0;
            defselect();
        }
        int rtme = (int)time;
        timer.text = "Time: " + rtme + " s";
	}

    void defselect()
    {
        GameObject wdf = GameObject.FindGameObjectWithTag("wordDef");
        wdf.SetActive(false);
        defSelect.SetActive(true);
    }
}
